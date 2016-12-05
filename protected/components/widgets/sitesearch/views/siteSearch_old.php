<div id="search" class="well">
    <?php echo '<h5>' . CHtml::encode('Выберите специализацию') . '</h5>';?>
    <br />
                <div class="row-fluid">
                    <ul class="inline panel-title" id="specialityCloud">
                        <?php     
                            /*
                            foreach ($specialitiesCloud as $key => $speciality):
                                echo '<li class="col-md-3"><h4>' . CHtml::ajaxLink($speciality, Yii::app()->controller->createUrl('home/showFilter/'), array('type'=> 'POST', 'data'=>array('speciality' => $key), 
                                'success' => 'function(response){
                                              $("#filter").empty();
                                                
                                              var obj = jQuery.parseJSON( response ); 
                                              $.each(obj, (function(key, value) {

                                                var dropdownList = $("<select></select>");
                                                dropdownList.attr("id", "SearchForm_" + key).attr("name", "SearchForm[" + key + "]").addClass("col-md-3");          
                                                
                                                $.each(value, function(k, v) {
                                                    dropdownList.append($("<option>").text(k + "..").val(null));
                                                    $.each(v, function(kk, vv) {
                                                        dropdownList.append($("<option>").text(vv.value).attr("value", vv.id));  
                                                    })      
                                                });                                                 
                                                                                   
                                                $("#filter").append(dropdownList);
                                              }));  $("#searchForm").show();
                                              }'
                                
                                
                                )) . '<h4></li>';              
                            
                            endforeach;
                            */
                        ?>
                    </ul>
                </div> 
                
                <?php $url = $this->getController()->createUrl($modelName);?>
                <?php $url = Yii::app() -> createAbsoluteUrl($modelName) ?>
                <?php echo CHtml::beginForm($url, 'post', array('id' => 'filterForm')); ?>                
                
                <div class="row-fluid">
                    <ul class="inline panel-title" id="specialityCloud_">
                        <?php     
                            foreach ($specialitiesCloud as $key => $speciality):
                                echo '<li class="col-md-3"><h4>' . CHtml::linkButton($speciality, array('id' => $key, 'name' => 'specialitySelected', 'class' => ((isset($fromPage['speciality']) && $fromPage['speciality'] == $key)? 'clicked': '' ))) . '<h4></li>';
                            endforeach;
                            echo CHtml::hiddenField($modelName.'SearchForm[speciality]', (isset($fromPage['speciality'])? $fromPage['speciality']: ''));

                        ?>
                    </ul>
                </div>             
                <div id="searchForm" class="row-fluid" style="<?php (isset($fromPage)? 'display: block' : 'display: block')?> ">                
                    <hr>
                    <div class="row-fluid">
                        <?php echo CHtml::dropDownList($modelName.'SearchForm[metro]',  (isset($fromPage['metro'])? $fromPage['metro']: ''), $metro, array('empty' => CHtml::encode('Метро..'), 'class' => 'col-md-3')); ?>
                        <?php echo CHtml::dropDownList($modelName.'SearchForm[district]', (isset($fromPage['district'])? $fromPage['district']: ''), $district, array('empty' => CHtml::encode('Район..'), 'class' => 'col-md-3')); ?>
                    </div>
                    
                    <div id="filter2" class="row-fluid">
                        <?php
                            if ($filterForm) {
								//echo "<textarea>filter</textarea>";
                                foreach($filterForm as $key => $fields):
                                    $items = array();
                                    $items[null] = key($fields) . '...';
                                    $fieldArray = array_values($fields);
                                    foreach ($fieldArray[0] as $f) :
                                        $items[$f->id] = $f->value;       
                                    
                                    endforeach;
                                    echo CHtml::dropDownList($modelName.'SearchForm[' . $key .']',  (isset($fromPage[$key])? $fromPage[$key]: ''), $items, array('class' => 'col-md-3'));
                                endforeach;
							}
                        ?>
                    </div>
                    <hr>
                    <div class="row-fluid buttons">
                        <?php echo Chtml::link('Показать все', $modelName.'?clear=1', array('id' => 'showAll', 'class'=>'btn btn-info pull-right')); ?>
                        <?php echo Chtml::link('Доктора', 'doctors', array('id' => 'doctors', 'class'=>'btn btn-info pull-right', 'style' => $modelName == 'doctors' ? 'color:red': '')); ?>
                        <?php echo Chtml::link('Клиники', 'clinics', array('id' => 'clinics', 'class'=>'btn btn-info pull-right', 'style' => $modelName == 'clinics' ? 'color:red': '')); ?>
                        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'success', 'label'=>'Показать', 'htmlOptions'=>array('class'=>'pull-right'))); ?>
                    </div>
                                                  
                 </div>                
                 <?php unset($fromPage); ?>
                 <?php echo CHtml::endForm(); ?>

</div>
<script lang="javascript">
    $(function() { 
        $('a[name="specialitySelected"]').click (function() {
            $('#'+'<?php echo $modelName; ?>'+'SearchForm_speciality').val($(this).attr('id'));    
        });
        
        $('#showAll').click (function() {
            $('#filterForm').trigger('reset');  
        });
        
        words = <?php echo json_encode($specialitiesCloud); ?>;
        //$("#specialityCloud").empty();
        //$("#specialityCloud").jQCloud(words);
     }); 
</script>