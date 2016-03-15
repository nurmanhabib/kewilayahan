# Kewilayahan Indonesia API

### Install

 - Instalasi dengan Composer
	<pre>
    $ composer require nurmanhabib/kewilayahan
	</pre>
 - Tambahkan `Nurmanhabib\Kewilayahan\KewilayahanServiceProvider::class` pada `config/app.php`
	<pre>
    'providers' => [
        ...         
        Nurmanhabib\Kewilayahan\KewilayahanServiceProvider::class,
    ]
	</pre>
 - Copy file `config.php` ke `config/kewilayahan.php`
    <pre>
    $ php artisan vendor:publish --provider="Nurmanhabib\Kewilayahan\KewilayahanServiceProvider"
    </pre>
 - Create table dengan migration
    <pre>
    $ php artisan migrate
    </pre>
 - Insert data seeder kewilayahan
    <pre>
    $ php artisan db:seed --class="KewilayahanSeeder"
    </pre>

### Penggunaan

<pre>
$kewilayahan = app('kewilayahan');
$kewilayahan->setQuery($request->all());
$kewilayahan->setOutput('api');

$kewilayahan->setOutput(function ($data) use ($request) {
	$selected = ['selected' => 'tes'];

	return array_merge($data, [$selected]);
});

return $kewilayahan->load();
</pre>

### License
Apache