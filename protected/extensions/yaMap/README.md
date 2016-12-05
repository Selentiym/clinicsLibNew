<h1>Yandex map, Yii</h1>

Yii extension for Yandex map.

copy files to

/protected/extensions/yaMap/

<h3>How it's work?</h3>

Define points on the map , set params, and place the widget
<pre>
&lt;?php $this-&gt;widget('ext.yaMap.YaMap',
	array(
		'points' =&gt; array(
			array(
				'lat' =&gt; 55.780669,
				'lng' =&gt; 49.144449,
				'icon' =&gt; '',
				'header' =&gt; Yii::app()-&gt;name,
				'body'=&gt; 'Юридический центр&lt;/br&gt;&lt;small&gt;звонок по России бесплатный&lt;/small&gt;',
				'footer' =&gt; '8-800-234-07-17',
				),
			),
		'params' =&gt; array('visible'=&gt;true,'zoom'=&gt;13,'width'=&gt;'750px','height'=&gt;'325px'),
	)
); ?&gt;
</pre>
