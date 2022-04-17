<a href="<?= $employerDetailsUrl ?>" class="employer flex flex-col justify-start items-center">
  <div class="flex justify-center items-center logo-image-wrapper rounded-full bg-white drop-shadow-md">
    <img src="<?= $employer->LogoPath ? $employer->LogoPath : $defaultLogo ?>" alt="" class="object-contain">
  </div>
  <p class="md:text-2xl  max-w-120 md:max-w-160 text-primary text-center"><?= $employer->EmployerName ?></p>
</a>