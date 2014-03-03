<?php
class TurnPage extends CWidget
{

    public function getTurnPageHtml ($num, $perpage, $curpage, $mpurl, $page = 10) {
        $multipage = '';
        //	$mpurl .= strpos ( $mpurl, '?' ) ? '&amp;' : '?';
        if ($num > $perpage) {
            $offset = 2;
            $pages = @ceil( $num / $perpage );
            if ($page > $pages) {
                $from = 1;
                $to = $pages;
            }
            else {
                $from = $curpage - $offset;
                $to = $from + $page - 1;
                if ($from < 1) {
                    $to = $curpage + 1 - $from;
                    $from = 1;
                    if ($to - $from < $page) {
                        $to = $page;
                    }
                }
                elseif ($to > $pages) {
                    $from = $pages - $page + 1;
                    $to = $pages;
                }
            }
            $pageHtml = array(
                
                    'num' => $num, 
                    'pages' => $pages, 
                    'page' => $page, 
                    'curpage' => $curpage, 
                    'mpurl' => $mpurl, 
                    'offset' => $offset, 
                    'from' => $from, 
                    'to' => $to
            );
            $multipage = $this->getController()
                ->renderPartial( "/turnpage" , array(
                'pageHtml' => $pageHtml
            ) , TRUE );
        }
        return $multipage;
    }
}
