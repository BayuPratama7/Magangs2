<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';

// ==========================================
// AUTH ROUTES
// ==========================================
$route['auth/login'] = 'auth/auth/login';
$route['auth/process'] = 'auth/auth/process';
$route['auth/logout'] = 'auth/auth/logout';

// ==========================================
// DASHBOARD ROUTES (per role)
// ==========================================
$route['dashboard'] = 'dashboard/dashboard';
$route['dashboard/mahasiswa'] = 'dashboard/mahasiswa';
$route['dashboard/koordinator'] = 'dashboard/koordinator';
$route['dashboard/sekretaris'] = 'dashboard/sekretaris';
$route['dashboard/dosen'] = 'dashboard/dosen';
$route['dashboard/kaprodi'] = 'dashboard/kaprodi';
$route['dashboard/penguji'] = 'dashboard/penguji';

// ==========================================
// PROPOSAL ROUTES
// ==========================================
$route['proposal'] = 'proposal/proposal/index';
$route['proposal/store'] = 'proposal/proposal/store';
$route['proposal/koordinator'] = 'koordinator/index';
$route['proposal/koordinator/acc/(:num)'] = 'koordinator/acc/$1';
$route['proposal/koordinator/reject/(:num)'] = 'koordinator/reject/$1';
$route['proposal/kaprodi'] = 'proposal/kaprodi/index';
$route['proposal/kaprodi/acc/(:num)'] = 'proposal/kaprodi/acc/$1';
$route['proposal/kaprodi/reject/(:num)'] = 'proposal/kaprodi/reject/$1';

$route['koordinator'] = 'koordinator/index';
$route['koordinator/acc/(:num)'] = 'koordinator/acc/$1';
$route['koordinator/reject/(:num)'] = 'koordinator/reject/$1';
$route['koordinator/detail/(:num)'] = 'koordinator/detail/$1';
$route['koordinator/logbook'] = 'koordinator/logbook';
$route['koordinator/hasil'] = 'koordinator/hasil';

// ==========================================
// LOGBOOK ROUTES (Mahasiswa)
// ==========================================
$route['logbook'] = 'logbook/logbook/index';
$route['logbook/store'] = 'logbook/logbook/store';

// ==========================================
// LAPORAN ROUTES (Mahasiswa)
// ==========================================
$route['laporan'] = 'laporan/laporan/index';
$route['laporan/store'] = 'laporan/laporan/store';

// ==========================================
// DESIMINASI ROUTES (Mahasiswa)
// ==========================================
$route['desiminasi'] = 'desiminasi/desiminasi/index';
$route['desiminasi/store'] = 'desiminasi/desiminasi/store';
$route['desiminasi/upload_laporan_akhir'] = 'desiminasi/desiminasi/upload_laporan_akhir';

// ==========================================
// ADMIN ROUTES (Sekretaris)
// ==========================================
$route['admin/dpl'] = 'admin/admin/dpl';
$route['admin/assign_dpl'] = 'admin/admin/assign_dpl';
$route['admin/surat'] = 'admin/admin/surat';
$route['admin/create_surat'] = 'admin/admin/create_surat';
$route['admin/penguji'] = 'admin/admin/penguji';
$route['admin/assign_penguji'] = 'admin/admin/assign_penguji';
$route['admin/jadwal'] = 'admin/admin/jadwal';
$route['admin/create_jadwal'] = 'admin/admin/create_jadwal';
$route['admin/mitra'] = 'admin/admin/mitra';
$route['admin/create_mitra'] = 'admin/admin/create_mitra';
$route['admin/delete_mitra/(:num)'] = 'admin/admin/delete_mitra/$1';
$route['admin/sebaran'] = 'admin/admin/sebaran';
$route['admin/create_sebaran'] = 'admin/admin/create_sebaran';
$route['admin/delete_sebaran/(:num)'] = 'admin/admin/delete_sebaran/$1';

// ==========================================
// SEKRETARIS DESIMINASI ROUTES
// ==========================================
$route['sekretaris/desiminasi'] = 'sekretaris/desiminasi/index';
$route['sekretaris/desiminasi/proses/(:num)'] = 'sekretaris/desiminasi/proses/$1';
$route['sekretaris/desiminasi/simpan'] = 'sekretaris/desiminasi/simpan';
$route['sekretaris/desiminasi/tolak/(:num)'] = 'sekretaris/desiminasi/tolak/$1';

// ==========================================
// DOSEN/DPL ROUTES
// ==========================================
$route['dosen/bimbingan'] = 'dosen/dosencontroller/bimbingan';
$route['dosen/detail/(:num)'] = 'dosen/dosencontroller/detail/$1';
$route['dosen/logbook'] = 'dosen/dosencontroller/logbook';
$route['dosen/logbook_review/(:num)/(:any)'] = 'dosen/dosencontroller/logbook_review/$1/$2';
$route['dosen/laporan'] = 'dosen/dosencontroller/laporan_list';
$route['dosen/laporan_acc/(:num)'] = 'dosen/dosencontroller/laporan_acc/$1';
$route['dosen/laporan_revisi/(:num)'] = 'dosen/dosencontroller/laporan_revisi/$1';
$route['dosen/jadwal'] = 'dosen/dosencontroller/jadwal';

// ==========================================
// PENGUJI ROUTES
// ==========================================
$route['penguji/konfirmasi'] = 'penguji/pengujicontroller/konfirmasi';
$route['penguji/konfirmasi_terima/(:num)'] = 'penguji/pengujicontroller/konfirmasi_terima/$1';
$route['penguji/konfirmasi_tolak/(:num)'] = 'penguji/pengujicontroller/konfirmasi_tolak/$1';
$route['penguji/jadwal'] = 'penguji/pengujicontroller/jadwal';
$route['penguji/input_hasil/(:num)'] = 'penguji/pengujicontroller/input_hasil/$1';
$route['penguji/simpan_hasil/(:num)'] = 'penguji/pengujicontroller/simpan_hasil/$1';
$route['penguji/laporan'] = 'penguji/pengujicontroller/laporan';
$route['penguji/laporan_acc/(:num)'] = 'penguji/pengujicontroller/laporan_acc/$1';
$route['penguji/laporan_revisi/(:num)'] = 'penguji/pengujicontroller/laporan_revisi/$1';

// ==========================================
// INFO ROUTES (Dashboard Content)
// ==========================================
$route['info/mitra'] = 'info/info/mitra';
$route['info/sebaran'] = 'info/info/sebaran';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
