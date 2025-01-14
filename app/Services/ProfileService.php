<?php

namespace App\Services;

use App\Repositories\ProfileRepository;

class ProfileService
{
  private ProfileRepository $profileRepository;

  public function __construct(ProfileRepository $profileRepository)
  {
    $this->profileRepository = $profileRepository;
  }

  public function updateProfile($user_id, $profile_details)
  {
    $this->profileRepository->updateProfile($user_id, $profile_details);
  }
}
