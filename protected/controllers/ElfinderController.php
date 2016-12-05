<?php

	class ElfinderController extends Controller {

		// don't forget configure access rules

		public function actions() {
			return array(
				// main action for elFinder connector
				'connector' => array(
					'class' => 'application.extensions.elFinder.ElFinderConnectorAction',
					// elFinder connector configuration
					// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
					'settings' => array(
						'roots' => array(
							array(
								'driver' => 'LocalFileSystem',
								'path' => Yii::getPathOfAlias('webroot') . '/images/',
								'URL' => Yii::app()->baseUrl . '/images/',
								'alias' => 'Root Alias',
                               
                                'mimeDetect' => "internal",
								'acceptedName' => '/^[^\.].*$/', // disable creating dotfiles
								'attributes' => array(
									array(
										'pattern' => '/\/[.].*$/', // hide dotfiles
										'read' => false,
										'write' => false,
										'hidden' => true,
									),
								),
							)
						),
					)
				),
				// action for TinyMCE popup with elFinder widget
				'elfinderTinyMce' => array(
					'class' => 'application.extensions.elFinder.TinyMceElFinderPopupAction',
					'connectorRoute' => 'connector', // main connector action id
				),
				// action for file input popup with elFinder widget
				'elfinderFileInput' => array(
					'class' => 'ext.elFinder.ServerFileInputElFinderPopupAction',
					'connectorRoute' => 'connector', // main connector action id
				),
			);
		}

	}
