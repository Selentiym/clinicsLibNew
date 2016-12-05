<?php $this->setPageTitle($model->title); ?>
        <div class="span8">
        
                    <?php if(Yii::app()->user->hasFlash('commentSuccessfull')): ?>
                        <div class="alert-success">
                            <?php echo Yii::app()->user->getFlash('commentSuccessfull'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(Yii::app()->user->hasFlash('commentFailed')): ?>
                        <div class="alert-danger">
                            <?php echo Yii::app()->user->getFlash('commentFailed'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="page-header">
						<?php 
							echo CHtml::link('Поиск', '/doctors');
							echo CHtml::encode("->");
							echo CHtml::link($model -> name, '/doctors/' . $model -> verbiage);
							echo CHtml::encode("->");
							echo CHtml::link('Файлы и отзывы', '/doctors/' . $model -> verbiage . '/other');
						?>
                        <h1> <?php echo CHtml::encode($model->name); ?> </h1>
                    </div>
                    <br/>
                     <div <?php echo ($model->audio == '')? 'class="thumbnail"': ''?> id="audio">
                        <?php if (trim($model->audio) != '') { ?>
                            <?php
                                $this->widget('application.extensions.jouele.Jouele', array(
                                    'file' => Yii::app()->baseUrl. '/files/doctors/' . $model->id . '/'. trim($model->audio),
                                    'name' => trim($model->audio),
                                    'htmlOptions' => array(
                                        'class' => 'jouele-skin-silver',
                                    )
                                ));
                            ?>
                        <?php } else { ?>
                            <h3>
                                <?php echo CHtml::encode('Аудиофайл отсутствует'); ?>
                            </h3>
                        <?php }; ?>                            
                    </div>
                    <br/>
                    <div <?php echo ($model->video == '')? 'class="thumbnail"': ''?> id="video">
                        <?php if (trim($model->video) != '') { ?>
                                <?php $this->widget('application.extensions.Yiitube', array('v' => $model->video)); ?>
                        <?php } else { ?>
                            <h3>
                                <?php echo CHtml::encode('Видеофайл отсутствует'); ?>
                            </h3>
                        <?php }; ?>
                    </div>
                    <br/>
                    <div class="thumbnail" id="comments">
                        <h3>
                            <?php echo CHtml::encode('Комментарии'); ?>
                        </h3>
                        <hr>
                        <div>
                        <?php if (!empty($model->comments)) : ?>                        
                                <ul>
                                    <?php foreach ($model->comments as $comment): ?>
                                        <li>
                                            <div>
                                                <?php echo $comment->text; ?>
                                                <br/>
                                                <?php if ($comment->user_first_name and $comment->user_last_name): ?>
                                                    <span class="pull-right"><?php echo mb_convert_case($comment->user_first_name, MB_CASE_TITLE, 'UTF-8') . ' ' . mb_convert_case($comment->user_last_name, MB_CASE_TITLE, 'UTF-8'); ?></span>
                                                    <br/>
                                                <?php endif; ?>
                                                <span class="pull-right"><?php echo CHTml::encode('Добавлен: '); ?> <?php echo $comment->create_at; ?></span>
                                            </div>
                                            <hr>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                        <?php else: ?>
                                <b> <?php echo CHtml::encode('Отзывы не найдены.'); ?> </b><br/><br/>
                        <?php endif; ?>
                            <p class="last-line-action">
                                <a id="add_comment_<?php echo $model->id;?>" class="btn btn-default" onclick="javascript: showCommentForm(this);">
                                <?php echo CHtml::encode('Добавить отзыв'); ?></a>
                            </p>
                            
                            <!-- Put this script tag to the <head> of your page -->
                            
                            <?php $this->renderPartial('/doctors/_comment_form', array('model'=>$add_comment, 'isNew' => $isNew, 'object_id' => $model->id, 'verbiage' => $model->verbiage)); ?>
                        </div>

                    </div>
                    <script type="text/javascript">
                      VK.init({apiId: 4825414, onlyWidgets: true});
                    </script>
                    
                    <!-- Put this div tag to the place, where the Comments block will be -->
                    <div id="vk_comments"></div>
                    <script type="text/javascript">
                    VK.Widgets.Comments("vk_comments", {limit: 10, width: "665", attach: "*"});
                    </script>                    
        </div>