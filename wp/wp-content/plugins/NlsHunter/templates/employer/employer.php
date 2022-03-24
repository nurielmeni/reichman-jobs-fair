<a href="<?= $employerDetailsUrl ?>" class="employer flex flex-col justify-start items-center">
  <div class="rounded-full bg-white drop-shadow-md p-6 md:p-8">
    <img src="<?= $employer->LogoPath ? $employer->LogoPath : $defaultLogo ?>" alt="" class="w-12 md:w-20 h-12 md:h-20">
  </div>
  <p class="md:text-2xl  max-w-120 md:max-w-160 text-primary text-center"><?= $employer->EmployerName ?></p>
</a>