<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DisplayTableExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('displayBody', [$this, 'displayBody']),
        ];
    }

    public function displayBody($data)
    {
        $html = '';

        foreach ($data['organizations'] as $id=>$element) {

            $html .=    '<tr>
            <th scope="row">'  .$id. '</th>
            <td>'. $element['name'] .'</td>
            <td>'. $element['description'] .'</td>
            <td><a href="/organization/edit_action/'.$id.'"  class="btn btn-success">edit</a></td>
            <td><a href="/organization/delete_action/'.$id.'" class="btn btn-danger" >delete</a></td>
        </tr>';
        }

        return $html;
        dump($data);exit;
    }
}
