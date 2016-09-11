<?php

namespace App\FrontModule\Presenters;

use App\Components\CategoryTreeTrait;
use Nette;

class HomepagePresenter extends Nette\Application\UI\Presenter
{
    use CategoryTreeTrait;
}
