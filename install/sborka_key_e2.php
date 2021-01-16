<?PHP

function createDir( $dir ) {
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
	} else {
		exec( "mkdir ".$dir."" );
	}
}

$pathe= ROOT_DIR . '/engine/';
@chmod($pathe, 0777);

$htaccess_text = '
<FilesMatch ".*">
   Order allow,deny
   Deny from all
</FilesMatch>

<FilesMatch "\.(avi|mp3|mp4|flv|swf|wmv|jpg|JPG|jpeg|gif|GIF|png|PNG)$|^$">
   Order deny,allow
   Allow from all
</FilesMatch>';

$htaccess_cache_text = '
Order Deny,Allow
Deny from all';

$important_dirs = array(
'./backup',
'./uploads',
'./uploads/files',
'./uploads/fotos',
'./uploads/afisha_photo',
'./uploads/afisha_photo/thumb_1',
'./uploads/afisha_photo/thumb_2',
'./uploads/album_club',
'./uploads/album_club_2',
'./uploads/album_club_3',
'./uploads/album_club_4',
'./uploads/archiv_video',
'./uploads/archiv_video/image',
'./uploads/banners',
'./uploads/club_fotos',
'./uploads/doska',
'./uploads/photoreportage',
'./uploads/photoreportage/thumb',
'./uploads/doska/image',
'./uploads/doska/thumb',
'./uploads/doska/thumb_mini',
'./uploads/download',
'./uploads/download/video',
'./uploads/download/video/thumbs',
'./uploads/exclusive',
'./uploads/exclusive/img',
'./uploads/firm_fotos',
'./uploads/firm_fotos/album',
'./uploads/firm_fotos/market',
'./uploads/firm_fotos/market/thumb',
    './uploads/firm_fotos/objects',
    './uploads/firm_fotos/objects/thumb',
'./uploads/firm_fotos/skidki',
'./uploads/firm_fotos/skidki/thumb',
'./uploads/firm_fotos/pharmacy',
'./uploads/firm_fotos/pharmacy/thumb',
'./uploads/firm_price',
'./uploads/forum',
'./uploads/forum/files',
'./uploads/forum/images',
'./uploads/forum/thumbs',
'./uploads/foto_conkurs',
'./uploads/foto_conkurs_2',
'./uploads/foto_conkurs_3',
'./uploads/foto_conkurs_4',
'./uploads/fotoalbum',
'./uploads/fotoalbum/full',
'./uploads/fotoalbum/full/main',
'./uploads/fotoalbum/main',
'./uploads/fotoalbum/temp',
'./uploads/fotoalbum/thumb',
'./uploads/fotoalbum/thumb/main2',
'./uploads/fotoalbum/thumb/mini',
'./uploads/fotoalbum/thumb/mini1',
'./uploads/fotos2',
'./uploads/fotos3',
'./uploads/fotos4',
'./uploads/games',
'./uploads/games/images',
'./uploads/get_photo_print',
'./uploads/medals',
'./uploads/datting',
'./uploads/datting/profile_photo',
'./uploads/datting/profile_photo_2',
'./uploads/datting/profile_photo_3',
'./uploads/datting/profile_photo_4',
'./uploads/datting/profile_photo_5',
'./uploads/my_garage',
'./uploads/my_garage/image',
'./uploads/my_garage/thumb',
'./uploads/my_garage/thumb_mini',
'./uploads/my_music',
'./uploads/my_video',
'./uploads/partner',
'./uploads/pogoda',
'./uploads/posts',
'./uploads/posts/thumbs',
'./uploads/posts/medium',
'./uploads/rating',
'./uploads/resized',
'./uploads/search',
'./uploads/search/cache',
'./uploads/slider',
'./uploads/thumbs',
);

foreach($important_dirs as $file){
$open = is_dir($file);
if ($open=='')
{
	$exit_dir = mkdir($file, 0777);
		if (!$exit_dir) {
		   createDir($file);
		}
}
}


foreach($important_dirs as $file){
if (!file_exists( $file."/.htaccess" ))	file_put_contents ($file."/.htaccess", $htaccess_text, LOCK_EX);
else @chmod($file."/.htaccess", 0444 );
}

$important_dirs_file = array(
'./engine/cache',
'./engine/cache/cacheuser',
'./engine/cache/cacheuser/title',
'./engine/cache/games',
'./engine/cache/logs',
'./engine/cache/online',
'./engine/cache/pogoda',
'./engine/cache/system',
'./engine/cache/system/dayuser_com',
'./engine/cache/system/friend_list',
'./engine/cache/system/garage',
'./engine/cache/system/market',
'./engine/cache/system/market/category',
'./engine/cache/system/market/rss',
    './engine/cache/system/objects',
    './engine/cache/system/objects/category',
    './engine/cache/system/objects/rss',
'./engine/cache/system/pharmacy',
'./engine/cache/system/pharmacy/category',
'./engine/cache/system/pharmacy/rss',
'./engine/cache/system/skidki',
'./engine/cache/system/skidki/category',
'./engine/cache/system/skidki/rss',
'./engine/cache/system/pm',
'./engine/cache/system/user_com',
'./engine/cache/system/user_list',
'./engine/modules/content/fotoalbum',
'./engine/modules/content/forum/cache/system',
'./engine/modules/content/fotoalbum/cache',
'./engine/modules/content/fotoalbum/cache/system',
);

foreach($important_dirs_file as $files){
$open = is_dir($files);
if ($open=='')
{
	$exit_dirs = mkdir($files, 0777);
		if (!$exit_dirs) {
		   createDir($files);
		}
}
}


foreach($important_dirs_file as $file){
if (!file_exists( $file."/.htaccess" ))	file_put_contents ($file."/.htaccess", $htaccess_cache_text, LOCK_EX);
else @chmod($file."/.htaccess", 0444 );
}

$pathe= ROOT_DIR . '/engine/';
@chmod($pathe, 0755);
?>