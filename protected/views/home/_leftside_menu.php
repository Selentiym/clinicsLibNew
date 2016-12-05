<?php
    //$leftside_menu = Options::model()->findByAttributes(array('name' => 'leftside_menu'));
    //$menu_items = array_map('trim', explode(';', $leftside_menu->value));

    //$menu_subitems = array_map('trim', explode('&', $leftside_menu->subvalue));
    //$menu = array();

    $menu = Menus::model()->with('articles')->findAll(array('with' => array('articles'), 'select' => array('t.id', 't.name', 't.verbiage'), 'order' => 't.name desc'));
    $menu_items = array();

    foreach ($menu as $item) { //($menu_items as $key => $item) {
        //var_dump ($item); die();

        /*
        $menu_links = '';
        //foreach($menu_subitems as $subitem) {

        $content_items = array_map('trim', explode(';', $menu_subitems[$key]));
        $content = '';
        foreach ($content_items as $subitem) {
            $subitems = array_map('trim', explode('=', $subitem));
            $content .= '<p class="page_item"><i class="icon-folder-open "></i>&nbsp;' . CHtml::link($subitems[0], Yii::app()->baseUrl . '/article/' . $subitems[1]) . '</p>';
        }
        */
        
        /*
        $menu_subitems = Articles::model()->findAllByAttributes(array('menu_sublevel' => trim($item)));
        $content = '';

        foreach ($menu_subitems as $subitem) {
            $content .= '<p class="page_item"><i class="icon-check "></i>&nbsp;' . CHtml::link($subitem->name, Yii::app()->baseUrl . '/article/' . $subitem->verbiage) . '</p>';
        }

        $menu[] = array('label'=>$item, 'content' => $content);
        */
        
        $content = '';
        foreach ($item->articles as $article) {
            $content .= '<p class="page_item"><i class="icon-check"></i>&nbsp;' . CHtml::link($article->name, Yii::app()->baseUrl . '/article/' . $article->verbiage) . '</p>';
        }
        $menu_items[] = array('label'=> $item->name, 'content' => $content, 'title' => $item->verbiage);
        
    } //var_dump($menu_items); die();
?>
<div class="span2">
    <?php echo '<h5>' . CHtml::encode('Медицинская библиотека') . '</h5>'; ?>
    <br />
    <div class="panel-group" id="articles">
            <?php foreach ($menu_items as $key => $item) { ?>
                <div>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="icon-folder-open"></i>&nbsp;<a data-parent="#articles" data-href="<?php echo $item['title']?>" href="<?php echo Yii::app()->controller->createUrl('/article/' .$item['title'], array('#' => 'all')); ?>"><?php echo $item['label']?></a>
                        </h4>
                    </div>
                    <div id="<?php echo $item['title']?>" class="panel-collapse collapse "> <?php //echo ($key != 1)? 'in': ''; ?>
                        <div class="panel-body">
                            <p>
                                </i><?php echo $item['content']; ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            <?php } ?>
        </div>
</div>