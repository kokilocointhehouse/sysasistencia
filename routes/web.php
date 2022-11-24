<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('asistencia.inicio.index');
// });

Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');



// Rutas para el ADMINISTRADOR
Route::resource('personal/asistencia','PAsistenciaController');
Route::resource('dashboard-administrador','DashController');
Route::resource('configuracion/empresa','ConfiguracionEmpresaController');
Route::resource('asistencia/informe_global','InformeGlobalController');
Route::resource('asistencia/reporte_mensual','ReporteMGlobalController');
Route::resource('acceso/usuarios','UsuarioController');
Route::resource('acceso/branchoffice','BranchOfficeController');
Route::resource('caja/pago','PagoController');

// Rutas para el PERSONAL
Route::resource('asistencia/registro','RegistroController');
Route::resource('asistencia/informe','InformeController');
Route::resource('reporte/mensual','ReporteMensualController');
Route::resource('reporte/grafico','ReporteGraficoController');
Route::resource('configuracion/mi_perfil','MAsistenciaController');
Route::resource('reporte/mis_pagos','MPagoController');

Route::resource('asistencia/inicio','AsistenciaController');
// Pagos pdf
Route::get('pago/{id}/{id2}/{id3}', 'PagoController@pago')->name('pago.pdf');

// Rutas extras
Route::post('marcarsalida', 'RegistroController@marcarsalida')->name('marcarsalida');

// Reporte De DashBoard
Route::get('detalle_grafico/{id}/{id2}', 'DashController@detallePdf')->name('detalle_grafico.pdf');

// Reporte de asistencia de Hoy
Route::get('detalle/{id}', 'RegistroController@detallePdf')->name('detalle.pdf');

// Reporte entre fechas
Route::get('rango_fecha/{id}/{id2}/{id3}', 'InformeController@rango_fechaPdf')->name('rango_fecha.pdf');
// Reporte entre fechas en Excel
Route::get('rango_fecha_excel/{id}/{id2}/{id3}', 'InformeController@rango_fechaExcel')->name('rango_fecha.excel');
// Reporte Mensual Pdf
Route::get('reporte_mensual_pdf/{id}/{id2}/{id3}', 'ReporteMensualController@reportePdf')->name('reporte_mensual.pdf');
// Reporte Mensual en Excel
Route::get('reporte_mensual/{id}/{id2}/{id3}', 'ReporteMensualController@reporteExcel')->name('reporte_mensual.excel');
// Reporte Gráfico en Pdf
Route::get('reporte_grafico_personal/{id}/{id2}', 'ReporteGraficoController@reportegp')->name('reporte_grafico_personal.pdf');
// Reporte Gráfico
// ------------------
Route::resource('auth','LoginController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('login', 'Auth\LoginController@login')->name('login');
