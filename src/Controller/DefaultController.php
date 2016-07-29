<?php

namespace App\Controller;


use App\Component\Controller;
use App\Model\DefaultModel;


class DefaultController extends Controller
{
    // Test 8
	public function defaultAction($message=null)
	{
        $title = ($message) ? $message : __METHOD__;

		$model = new DefaultModel();
		$links = $model->getLinks();

		if (isset($links['default'])) {
			unset($links['default']);
		}

		return $this->fetch('default.html.php', [
			'title' => $title,
			'content' => $links,
		]);
	}
}
