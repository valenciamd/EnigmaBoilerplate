<?php
/***************************************************************************************************
 * TEMPLATE CLASS
 ***************************************************************************************************
 * Handles the creation and rendering of templates to the page.
 **************************************************************************************************/

class Template{
    
    private $site;
    private $page;
    
    public function __construct() {
        $this->site = new Site();
        $this->page = new Page();
    }
    
    public function addTemplateBit($tag, $bit){
        if(strpos($bit, 'themes/') == FALSE):
            $bit = 'themes/'.$this->site->getTheme().'/layout/templates/'.$bit.'.php';
        endif;
        $this->page->addTemplateBit($tag, $bit);
    }
    
    private function replaceBits(){
        $bits = $this->page->getBits();
        foreach($bits as $tag => $template):
            $templateContent = file_get_contents($template);
            $newContent = str_replace('{{'.$tag.'}}', $templateContent, $this->page->getContent());
            $this->page->setContent($newContent);
        endforeach;
    }
    
    private function replaceTags(){
        $tags = $this->page->getTags();
        foreach($tags as $tag => $data):
            if(is_array($data)):
                if($data[0] == 'SQL'):
                    $this->replaceDBTags($tag, $data[1]);
                elseif($data[0] == 'DATA'):
                    $this->replaceDataTags($tag, $data[1]);
                endif;
            else:
                $newContent = str_replace('{{'.$tag.'}}', $data, $this->page->getContent());
                $this->page->setContent($newContent);
            endif;
        endforeach;
    }
    
    private function replaceDBTags($tag, $cacheId){
        global $db;
        $block = '';
        $old_block = $this->page->getBlock($tag);
        if($tags = $db->resultsFromCache($cacheId)):
            for($i = 0; $i < count($tags); $i++):
                $new_block = $old_block;
                foreach($tags[$i] as $ntag => $data):
                    $new_block = str_replace('{{'.$ntag.'}}', $data, $new_block);
                endforeach;
                $block .= $new_block;
            endfor;
        endif;
        $pageContent = $this->page->getContent();
        $newContent = str_replace('<!-- START '.$tag.' -->'.$old_block.'<!-- END '.$tag .' -->', $block, $pageContent);
        $this->page->setContent($newContent);
    }
    
    private function replaceDataTags($tag, $cacheId){
        global $db;
        $block = $this->page->getBlock($tag);
        $old_block = $block;
        while($tags = $db->dataFromCache($cacheId)):
            foreach($tags as $ntag => $data):
                $new_block = $old_block;
                $new_block = str_replace('{{'.$ntag.'}}', $data, $new_block);
            endforeach;
            $block .= $new_block;
        endwhile;
        $pageContent = $this->page->getContent();
        $newContent = str_replace($old_block, $block, $pageContent);
        $this->page->setContent($newContent);
    }
    
    public function getPage(){
        return $this->page;
    }
    
    public function buildFromTemplates(){
        $bits = func_get_args();
        $content = "";
        foreach($bits as $bit):  
            if(strpos($bit, 'themes/') == FALSE):
                $bit = 'themes/'.$this->site->getTheme().'/layout/templates/'.$bit.'.php';
            endif;
            if(file_exists($bit) == TRUE):
                $content .= file_get_contents($bit);
            endif;
        endforeach;
        $this->page->setContent($content);
    }
    
    public function dataToTags($data, $prefix){
        foreach($data as $key => $content):
            $this->page->addTag($key.$prefix, $content);
        endforeach;
    }
    
    public function parseTitle(){
        $newContent = str_replace('<title>', '<title>' . $this->page->getTitle(), $this->page->getContent());
        $this->page->setContent($newContent);
    }
    
    public function parseOutput(){
        $this->replaceBits();
        $this->replaceTags();
        $this->parseTitle();
    }
}