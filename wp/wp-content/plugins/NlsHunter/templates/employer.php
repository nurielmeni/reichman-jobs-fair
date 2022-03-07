<a href="#" class="employer flex flex-col justify-start items-center">
  <div class="rounded-full bg-white drop-shadow-md p-8">
    <img src="<?= $employer[0]->LogoPath ? $employer[0]->LogoPath : $defaultLogo ?>" alt="" width="80" height="80">
  </div>
  <p class="text-2xl text-primary text-center"><?= $employer[0]->EmployerName ?></p>
</a>