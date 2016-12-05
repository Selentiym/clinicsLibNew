    <div class="span8">

                <?php $this->widget('application.components.widgets.sitesearch.SiteSearch', array('filterForm' => $filterForm)); ?>

                    <?php
					//echo $clinics[0];
                    if ($clinics)
                        $this->widget('zii.widgets.CListView', array(
                            'id' => 'clinics_list',
                            'dataProvider' => $clinics,
                            'ajaxUpdate'=> true,
                            'summaryText'=>'',
                            'template' => '{items}{pager}',
                            'itemView'=> '//home/_single_clinic',
                            //'afterAjaxUpdate' => 'js: $(".rateit").each(function(i){$(this).rateit()})',     
                            /*'pager' => array (
                                'class' => 'application.extensions.infiniteScroll.IasPager', 
                                'rowSelector'=>'.thumbnail', 
                                'listViewId' => 'clinics_list', 
                                'header' => '',
                                'loaderText'=> CHtml::encode('Подождите...'),
                                'options' => array('history' => true, 'triggerPageTreshold' => 20, 'trigger'=>'Показать еще','onRenderComplete'=>'js: function () {$(".rateit").rateit();}'),
                            ) */

                        ));
                    ?>                 
     </div>