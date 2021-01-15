<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DiDom\Document;
use DiDom\Query;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $domain = $request->old('domain[name]');
    return view('home', ['domain' => $domain]);
})->name('home');

Route::get('/domains', function () {

    $domains = DB::table('domains')
            ->join('domain_checks', 'domains.id', '=', 'domain_checks.domain_id')
            ->select('domains.*', 'domain_checks.status_code')
            ->get();

    return view('pages.domains', compact('domains'));
})->name('domains');

Route::get('/domains/{id}', function ($id) {
    $domain = DB::table('domains')->find($id);
    $domain_checks = DB::table('domain_checks')->where('domain_id', '=', $id)->get();
    return view('pages.domain', ['domain'=>$domain, 'domain_checks'=>$domain_checks]);
})->name('domain');

Route::post('/domains', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'domain.name' => 'required|max:255|url'
    ]);

    if ($validator->fails()) {
        return redirect(route('home'))
                    ->withErrors($validator)
                    ->withInput();
    }
    
    $domainName = mb_strtolower($request['domain']['name']);

    $findName = DB::table('domains')->where('name', '=', $domainName)->get();

    if ($findName->count() > 0) {
        flash('Domain exists');
        return redirect()->route('home');
    }

    DB::table('domains')->insert([
            'name' => $domainName,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]
    );
    flash('Domain added successfully');

    $findID = DB::table('domains')->where('name', $domainName)->value('id');
    return redirect()->route('domain', ['id' => $findID]);
})->name('domains.store');

Route::post('/domains/{id}/checks', function ($id) {
    $domainName = DB::table('domains')->find($id);
    $response = Http::get($domainName->name);

    $body = $response->getBody()->getContents();
    $document = new Document($body);

    $h1 = optional($document->first('h1'))->text();
    $keywords = optional($document->find('meta[name=keywords]::attr(content)'))[0];
    $description = optional($document->find('meta[name=description]::attr(content)'))[0];

    DB::table('domain_checks')->insert([
        'domain_id' => $id,
        'status_code' => $response->status(),
        'h1' => $h1,
        'keywords' => $keywords,
        'description' => $description,
        'updated_at' => Carbon::now(),
        'created_at' => Carbon::now()
    ]);
    DB::table('domains')->where('id', $id)->update(['updated_at' => Carbon::now()]);
    flash('Check added successfully');
    $domain_checks = DB::table('domain_checks')->get();
    return redirect()->route('domain', ['id' => $id]);
})->name('domain.check');
