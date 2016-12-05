<?php
class ClinicsObjectController extends BaseController
{
	public function Model()
	{
		return clinics::model();
	}
	public function setAdditionalProperties($clinic)
	{
		/* metro stations */
		$metros_array = array_map('trim', explode(';', $clinic->metro_station));
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $metros_array);
		$metros_array = Metro::model()->findAll($criteria);

		if (!empty($metros_array)) {
			foreach ($metros_array as $metro)
				$metros .= $metro->name . ', ';
		}
		$metros = substr($metros, 0, strrpos($metros, ','));
		$clinic->metros_display = $metros;

		/* districts */
		$districts_array = array_map('trim', explode(';', $clinic->district));
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $districts_array);
		$districts_array = Districts::model()->findAll($criteria);

		if (!empty($districts_array)) {
			foreach ($districts_array as $district)
				$districts .= $district->name . ', ';
		}
		$districts = substr($districts, 0, strrpos($districts, ','));
		$clinic->districts_display = $districts;
	}
}
?>