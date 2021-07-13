######tinker/ factory ############
1. membuat factories sendiri
	=> php artisan make:factory PostFactory -m Post
	=> buka filenya database/factories/PostFactory.php
		'title' => $faker->sentence(),
	        'slug'  => \Str::slug($faker->sentence()),
	        'body'  => $faker->paragraph(10),
	=> php artisan tinker
	=> factory('App\Post', 10)->create();
utk Lar8 sedikit berbeda
	=> php artisan tinker
	=> Post::factory()->count(5)->create()

2. menampilkan data tabel dari tinker
	=> php artisan tinker
	=> Post::find(1);
	=> Post::first();
	=> Post::latest()->first();