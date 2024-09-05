<?php
// app/View/Components/AvatarName.php
namespace App\View\Components;

use Illuminate\View\Component;

class AvatarName extends Component
{
  public $avatar;
  public $firstName;
  public $lastName;

  public function __construct($avatar, $firstName, $lastName)
  {
    $this->avatar = $avatar;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
  }

  public function render()
  {
    return view('components.avatar-name');
  }
}
