    <div class="span8" style="margin-top: -20px">
                    <?php 
                        if ($articles)
                            $this->widget('zii.widgets.CListView', array(
                                'id' => 'articles_list',
                                'dataProvider' => $articles,
                                'ajaxUpdate'=> true,
                                'summaryText'=>'',
                                'template' => '{items}',
                                'itemView'=> '_single_article',
                                //'afterAjaxUpdate' => 'js: $(".rateit").each(function(i){$(this).rateit()})',     
                                'pager' => array (
                                    'class' => 'application.extensions.infiniteScroll.IasPager', 
                                    'rowSelector'=>'.thumbnail', 
                                    'listViewId' => 'articles_list', 
                                    'header' => '',
                                    'loaderText'=> CHtml::encode('Подождите...'),
                                    'options' => array('history' => true, 'triggerPageTreshold' => 20, 'trigger'=>'Показать еще'),
                                )
    
                            ));
                    ?>
    </div>                    