<?php

namespace App\Controller;


use App\Component\Controller;
use App\Model\TestModel;


class TestController extends Controller
{
	// Test1
	public function tagAction()
	{
		$model = new TestModel();
		return $this->fetch('test.html.php', [
			'title' => __METHOD__,
			'content' => $model->tag($model->getText()),
		]);
	}

	// Test2
	public function keyAction()
	{
		$model = new TestModel();
		return $this->fetch('test.html.php', [
			'title' => __METHOD__,
			'content' => $model->key($model->getText()),
		]);
	}

    // Test6
    public function showClonesAction()
    {
        $model = new TestModel;
        return $this->fetch('clones.html.php', array_merge($model->getClones(), [
            'title' => __METHOD__,
        ]));
    }

    // Test7
    public function showCombinationsAction()
    {
        $model = new TestModel;
        $array = [
			['a1', 'a2', 'a3',],
			['b1', 'b2',],
			['c1', 'c2', 'c3',],
			['d1',],
		];
		return $this->fetch('combinations.html.php', [
            'title' => __METHOD__,
			'data' => $array,
            'content' => $model->getCombinations($array),
        ]);
    }
}
