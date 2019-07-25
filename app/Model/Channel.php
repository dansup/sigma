<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Pixelfed\Snowflake\HasSnowflakePrimary;

class Channel extends Model
{
	use HasSnowflakePrimary;

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	public function url()
	{
		return url('/c/' . $this->id);
	}

	public function adminUrl()
	{
		return url('/dashboard/channel/manage/' . $this->id);
	}
}
