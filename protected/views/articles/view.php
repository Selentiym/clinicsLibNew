<div class="main_content">
	<div class="in_main_content">
	
		<?php if (empty($children)): ?>
		<div class="in_main_content_left article_left ">
			<?php $this->renderPartial('//articles/_navBar', array('article' => $model)); ?>
			<!--<div class="zagolovok_spravka">
				<h1><?php echo $model -> name; ?></h1>
			</div>-->
			<div class="article_content">
				<div class="article_top" style="text-align:left; color:black; font-weight:bold; margin-bottom:30px;line-height:27px;margin-left:30px;margin-top: 30px;font-size:20px">
					Нужен хороший врач, клиника или услуги диагностики?<br/>
					Ищите и записывайтесь здесь – это удобно и дешевле, чем в клинике!<br/>
					<br/>
					Поиск клиники <?php echo CHtml::link('тут...',Yii::app() -> baseUrl.'/clinics?clear=1'); ?><br/>
					Поиск врача <?php echo CHtml::link('здесь...',Yii::app() -> baseUrl.'/doctorsList'); ?>

				</div>
				<?php echo $model -> giveModifyedText(); ?>
				<?php 
				if ($prev):
					//echo $model -> verbiage.'<br/>';
					//echo $prev['verbiage'].'<br/>';
					//echo $model -> GenerateUrl().'<br/>';
					
					echo "<div><a href='".$prev['verbiage']."'>".$prev['name']."</a></div>";
				endif; ?>
				<?php 
				if ($next):
					echo "<div><a href='".$next['verbiage']."'>".$next['name']."</a></div>";
				endif; ?>
			</div>
			
			<!--<div class="snimok">
				<img src="img/foto.png" alt="snimok">
				<p>Рис. 3.12 a-d Грыжа диска. Асимметричное выпячивание (а), протрузия и экструзия (Ь), расположение грыжи диска в горизонтальной (с) и сагиттальной проекциях (d). </p>
			</div>-->
		</div>
		<?php else: ?>
				<div class="in_main_content_left">
				<?php $this->renderPartial('//articles/_navBar', array('article' => $model)); ?>
                    <div class="zagolovok_spravka">
                        <h1><?php echo $model -> name; ?></h1>
                    </div>
                    <div class="spravka_content">
						<?php
							$translate = array(
								'Arterii_i_veny' => 'zabolev1.png',
								'LOR' => 'lor.png',
								'Golovnoj_mozg-osnovn' => 'mozg.png',
								'Golova_i_sheja-osnov' => 'heart.png',
								'Grudnaja_kletka-osno' => 'grud.png',
								'Pediatrija' => 'child.png',
								'Kardiologija' => 'kardio.png',
								'Molochnye_zhelezy' => 'moloch.png',
								'Mochepolovaja_sistem' => 'mochep.png',
								'Hirurgija' => 'zabolev1.png',
								'Pozvonochnik' => 'pozvonoch.png',
								'Ortopedija' => 'ortopedia.png'
							);
							$parents = $model -> getParentList();
							if ($model -> level == 0) {
								$parents[0] = array('verbiage' => $model -> verbiage);
							}
							foreach($children as $child) {
								$this -> renderPartial('//articles/_article_shortcut', array('article' => $child, 'image' => $translate[$parents[0]['verbiage']],'baseArticleUrl' => $model -> GenerateUrl()));
							}
						?>
                    </div>
                </div>

		<?php endif; ?>
		<?php $this -> renderPartial('//layouts/right_column'); ?>
	</div>
</div>
<div class="clear"></div>