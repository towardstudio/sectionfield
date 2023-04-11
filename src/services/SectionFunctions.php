<?php
namespace towardstudio\sectionfield\services;

use yii\base\Component;

use Craft;
use craft\services\Sections;
use craft\elements\Entry;

use towardstudio\sectionfield\SectionField;

class SectionFunctions extends Component
{
	public function sections(mixed $value = null): mixed
	{
		$query = [];

		// Check to make sure a value has been passed
		if (empty($value))
		{
			return 'Please add a section ID';
		}

		if (is_array($value))
		{
			foreach ($value as $key => $id)
			{
				array_push($query, Craft::$app->sections->getSectionById($id));
			};
		}
		elseif (is_int($value))
		{
			array_push($query, Craft::$app->sections->getSectionById($value));
		}
		else
		{
			return 'The value must be an array or int';
		}

		return $query;
	}

	public function entries(mixed $value = null): mixed
	{
		$query = [];

		// Check to make sure a value has been passed
		if (empty($value))
		{
			return 'Please add a section ID';
		}

		if (is_array($value))
		{
			foreach ($value as $key => $id)
			{
                array_push($query, $id);
            };
		}
		elseif (is_int($value))
		{
			array_push($query, $value);
		}
		else
		{
			return 'The value must be an array or int';
		}

		$query = Entry::find()->sectionId($query);

		return $query;
	}

}
