# robot

Adalah service yang menggenerasi rss feed dan sitemap. Masing-masing modul bisa 
menggenerasi rss feed/sitemap masing-masing dengan perintah `$this->robot->sitemap`
atau `$this->robot->feed`. Modul ini juga menyediakan global sitemap/rss feed yang
bisa diakses dari `/sitemap.xml`, dan `/feed.xml`.

Sumber data global sitemap/rss feed diambil dari handler yang didaftarkan pada
konfigurasi aplikasi. Contoh di bawah adalah contoh sederhana konfigurasi modul
ini.

```php
// ./etc/config.php

return [
    'name' => 'Phun',
    ...,
    'robot' => [
        'cache' => 86400,
        'sitemap' => [
            'module'  => 'Module\\Library\\Robot::sitemap',
            'module2' => 'Module2\\Library\\Robot::sitemap',
        ],
        'feed' => [
            'module'  => 'Module\\Library\\Robot::feed',
            'module2' => 'Module2\\Library\\Robot::feed',
        ]
    ]
];
```

Opsi `cache` digunakan untuk menentukan lamanya global sitemap/feed di cache. Aplikasi
harus menghapus cache ini secara manual jika ingin menghilangkannya sebelum masa
expired.

Opsi `sitemap` menyimpan informasi darimana saja konten `sitemap.xml|json` akan diambil.

Opsi `feed` menyimpan informasi darimana saja konten `feed.xml|json` akan diambil.

## sitemap handler

Penyedia konten sitemap ( `Module\Library\Robot::sitemap` ) diharapkan mengembalikan
data dalam bentuk seperti di bawah:

```
return [
    (object)[
        'url'           => 'http://cms.phu/page/about',
        'lastmod'       => '2017-05-30',
        'changefreq'    => 'monthly',
        'priority'      => 0.4,
        'image'         => (object)[    // optional
            'url'           => 'http://cms.phu/media/aa/bb/cc/aabbcc.jpg',
            'caption'       => 'Some Title',   // optional
            'title'         => 'Some Title'    // optional
        ]
    ],
    (object)[
        'url'           => 'http://cms.phu/page/contact',
        'lastmod'       => '2017-05-30',
        'changefreq'    => 'monthly',
        'priority'      => 0.4,
    ],
    ...
];
```

Silahkan mengacu ke [sitemaps.org](https://www.sitemaps.org/protocol.html) dan
[Google Image sitemaps](https://support.google.com/webmasters/answer/178636?hl=en)
untuk informasi lebih lanjut tentang masing-masing isi properti.

## feed handler

Penyedia konten feed ( `Module\Library\Robot::feed` ) diharapkan mengembalikan
data dalam bentuk seperti di bawah:

```
return [
    (object)[
        'author'        => 'Iqbal Fauzi',                           // optional
        'categories'    => ['News', 'Politics'],                    // optional
        'comment'       => 'http://cms.phu/post/jokowi#comments',   // optional
        'description'   => 'Ini adalah preface content',
        'page'          => 'http://cms.phu/post/jokowi',
        'published'     => '2017-05-30T07:50:38+00:00',
        'updated'       => '2017-05-30T07:50:38+00:00',
        'title'         => 'Jokowi Presiden Kita'
    ],
    (object)[
        'description'   => 'Ini adalah preface content',
        'page'          => 'http://cms.phu/post/windows',
        'published'     => '2017-05-30T07:50:38+00:00',
        'updated'       => '2017-05-30T07:50:38+00:00',
        'title'         => 'Release Windows 10'
    ],
    ...
];
```

## feed logo

Modul ini datang dengan default logo yang ditempatkan di `./theme/robot/static/logo.png`
dengan ukuran 72x72 pixel. Silahkan update logo tersebut agar sesuai dengan logo
aplikasi.