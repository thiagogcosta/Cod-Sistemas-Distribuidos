<?php
namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;

abstract class MongodbEventSubscriber
{
	protected $namespace = '';

	public function creating(Model $model){}

	public function created(Model $model){
		$attributes = $model->toArrayWithAttrs();
		$mongoModel = $model->newMongoModel();

		$mongoModel->create($attributes);
	}

	public function updating(Model $model){}

	public function updated(Model $model){
		$attributes = $model->toArrayWithAttrs();
		$mongoModel = $model->newMongoModel();

		unset($attributes['id']);
		$mongoModel->update($attributes);
	}

	public function deleting(Model $model){}

	public function deleted(Model $model){
		$model->newMongoModel()->delete();
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher $events
	 */
	public function subscribe($events)
	{
		$self = get_class($this);

		$events->listen("{$this->namespace}.creating", $self.'@creating');
		$events->listen("{$this->namespace}.created", $self.'@created');

		$events->listen("{$this->namespace}.updating", $self.'@updating');
		$events->listen("{$this->namespace}.updated", $self.'@updated');

		$events->listen("{$this->namespace}.deleting", $self.'@deleting');
		$events->listen("{$this->namespace}.deleted", $self.'@deleted');
	}
}