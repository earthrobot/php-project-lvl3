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

Route::get('/', function (Request $request) : Illuminate\View\View {
    $domain = $request->old('domain[name]');
    return view('home', ['domain' => $domain]);
})->name('home');

Route::get('/domains', function () : Illuminate\View\View {

    $domains = DB::table('domains')->get();

    $domain_checks = DB::table('domain_checks')
             ->select(DB::raw('distinct on (domain_id) *'))
             ->orderBy("domain_id")
             ->orderBy("created_at", "desc")
             ->whereIn('domain_id', $domains->pluck('id'))
             ->get()
             ->keyBy('domain_id');

    return view('domains.index', ['domains' => $domains, 'domain_checks' => $domain_checks]);
})->name('domains.index');

Route::get('/domains/{id}', function ($id) : Illuminate\View\View {
    $domain = DB::table('domains')->find($id);
    $domain_checks = DB::table('domain_checks')->where('domain_id', $id)->latest()->get();
    return view('domains.show', ['domain' => $domain, 'domain_checks' => $domain_checks]);
})->name('domains.show');

Route::post('/domains', function (Request $request) : Illuminate\Http\RedirectResponse {

    $validator = Validator::make($request->all(), [
        'domain.name' => 'required|max:255|url'
    ]);

    if ($validator->fails()) {
        return redirect(route('home'))
                    ->withErrors($validator)
                    ->withInput();
    }

    $domainName = mb_strtolower($request['domain']['name']);

    $domain = DB::table('domains')->where('name', $domainName)->first();

    if ($domain !== null) {
        flash('Domain exists');
        return redirect()->route('domains.show', ['id' => $domain->id]);
    }

    $id = DB::table('domains')->insertGetId([
        'name' => $domainName,
        'updated_at' => Carbon::now(),
        'created_at' => Carbon::now()
    ]);
    flash('Domain added successfully');

    return redirect()->route('domains.show', ['id' => $id]);
})->name('domains.store');

Route::post('/domains/{id}/checks', function ($id) : Illuminate\Http\RedirectResponse {

    $domainName = DB::table('domains')->find($id);

    try {
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
    } catch (Exception $e) {
        flash($e->getMessage());
    }

    return redirect()->route('domains.show', ['id' => $id]);
})->name('domains.checks.store');
