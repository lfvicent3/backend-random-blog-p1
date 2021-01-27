<?php
    namespace SCRAPPER;
    use OpenGraph;
    use SimpleLargeXMLParser;
    require_once(__DIR__ .'/opengraph.php');
    require_once(__DIR__.'/SimpleLargeXMLParser.class.php');
    
    echo "atuvi";
    $conexao = pg_connect('host=ec2-54-211-55-24.compute-1.amazonaws.com dbname=ddvktn95ntrs5s user=csaefyrianiztn password=03834d07a5fd8b4824686f3cf252c4ebb6b58e9915980f27bf6033d1160c8b07');
    $db_data = pg_query($conexao, "SELECT url FROM posts");
    $row = pg_fetch_all($db_data);
    
    $a = obter('https://www.gazetadopovo.com.br/feed/rss/agronegocio.xml');

    $ch = curl_init('https://random-blog-p1.herokuapp.com/api/post/add');
    foreach ($a as $key) {
        $link =  $key['link'];
        
        foreach ($row as $key1) {
            if($link == $key1['url']){
                break;
            }   
        }
        $data = array(
            'title' => $key['title'],
            'url' => $key['link'],
            'paragraph' => $key['description'],
            'image' => $key['enclosure']
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    }

    curl_close($ch);
    
    function obter(String $url)
     {
         $parser = new SimpleLargeXMLParser();
         $parser->loadXML($url);
         $cot = $parser->parseXML('//rss/channel/item', true);
         
         $arr = array();
         foreach ($cot as $itens) {
             $i['title'] = $itens['title']['0']['value']['title']['value'] ?? null;
             $i['link'] = $itens['link']['0']['value']['link']['value'] ?? null;
             $i['description'] = $itens['description']['0']['value']['description']['value'] ?? null;
             $i['pubDate'] = $itens['pubDate']['0']['value']['pubDate']['value'] ?? null;
             $i['enclosure'] = $itens['enclosure']['0']['attributes']['url'] ?? NoticiasFuncoes::og($i['link']);
             $arr[] = $i;
         }
     
         return $arr;
     }
 
class NoticiasFuncoes{
   public static function og($link)
     {
         $graph = OpenGraph::fetch($link);
         foreach ($graph as $key => $value) {
             if($key == 'image'){
                 return $value;
             }
         }
         return null;
     }
}
?>