<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	/**
	 * 为数组 / JSON 序列化准备日期。
	 *
	 * @param  \DateTimeInterface  $date
	 * @return string
	 */
	protected function serializeDate(DateTimeInterface $date)
	{
	    return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
	}
}