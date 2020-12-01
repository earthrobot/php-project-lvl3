<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/domains', function () {
    $domains = DB::table('domains')->get();
    return view('pages/domains', compact('domains'));
})->name('domains');

Route::get('/domains/{id}', function ($id) {
    $domain = DB::table('domains')->find($id);
    return view('pages/domain', compact('domain'));
})->name('domain');

Route::post('/domains', function (Request $request) {

    $validatedData = $request->validate([
        'domain.name' => 'required|max:255'
    ]);
    
    $domain = $validatedData['domain']['name'];
    $parsedDomain = parse_url($domain);
    if (empty($parsedDomain['host'])) {
        flash('Not a valid url.');
        return view('home');
    }

    $domainName = strtolower($parsedDomain['host']);

    $findName = DB::table('domains')->where('name', '=', $domainName)->get();

    if ($findName->count() > 0) {
        flash('Domain exists');
        return view('home');
    }

    DB::table('domains')->insert([
            'name' => $domainName,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]
    );
    flash('Domain added successfully');
    return view('home');
})->name('add-domain');
