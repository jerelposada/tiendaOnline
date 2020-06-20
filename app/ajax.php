<?php
require 'funcion.php';
$producto= get_producto();
//$response=
//[
  //  'status'=>200,
    //'mensaje'=>'hola soy tu primera respuesta en ajax',
    //'data'=>$producto
//];

// funcion para crear json en patallas
//print_r(get_producto());



// que tipo de peticion solicita ajax
if (!isset($_POST['action']))
{
  json_output(403);
    die;
}





//get cargar carro
$action=$_POST['action'];
switch ($action)
 {  
    case 'get':
        $cart=get_card(); 
        $outout= '<table  class=" tabla-carrito">';

      // si hay producto en el carrito 
      if(!empty($cart['producto']))
        {
            $outout .='  
            <tr  >
            <th class="cabecera">producto</th>
            <th class="cabecera">cantidad</th>
            <th class="cabecera">total</th>
            </tr>';
            foreach( $cart['producto'] as $p)
            { 
              $outout.=' <tr >
              <td class="contenido-producto">'.$p['nombre'].'</td>
              <td class="precio"><input type="text" class="btn-actualizarCarro " data-cantidad="'.$p['cantidad'].'" data-id="'.$p['id'].'" value="'.$p['cantidad'].'"></td>
              <td >$ '.$p['precio'].'
              <button data-id="'.$p['id'].'" class="btn-borrar-producto" >
              x
            </button> </td>
            </tr>';
            }
            $outout .=' </table>
          <button class="boton btn-vaciar-carrito">
          borrar carrito
        </button>';
          // si no hay producto en el carrito 
        }else {
            
        $outout .='
        
        <img src="img/empty-cart.png " alt="no ha cargado la imagen" >'.
        '<p>no hay articulo en el carrito</p>
      ';
        }

        $outout .='
  

    <div class="pago">
      <p>
        subtotal<span>------$'.$cart['cart_total']['subtotal'].'</span>
      </p>
      <p>
        envio <span>---------$'.$cart['cart_total']['envio'].'</span>
      </p>
      <p>
        total <span>---------$'.$cart['cart_total']['total'].'</span>
      </p>
    </div>
    <button class="btn-pago" disabled>
      pagar ahora
    </button>';
        json_output(200,'ok',$outout);
        break;

        case 'post':
          if (!isset($_POST['id'], $_POST['cantidad']))
         {
            json_output(403);
        }
        if (!add_to_cart((int)$_POST['id'] ,(int) $_POST['cantidad'])) 
        {
          json_output(400,'no se pudo agregar al carrito intenta de nuevo');
        }

        json_output(201);
      break;
      case 'destroy':
        if(!destroy_cart())
        {
          json_output(400,'no se pudo destruir el carrito');
        }
        json_output(200);
      break;
      case 'borrarElemento':
      if (!isset($_POST['id']))
      {
         json_output(403);
      }
      if(!borrar_elemento_carro((int)$_POST['id']))
      {
        json_output(400,'no se pudo borrar elemento del carrito');
      }
      json_output(200);
    break;

    case 'put':
      if (!isset($_POST['id'] ,$_POST['cantidad'])) 
      {
        json_output(403);
      }

      if(!updateCarro((int)$_POST['id'] ,(int) $_POST['cantidad']))
      {
        json_output(400,'no se pudo actualizar el producto');
      }

      json_output(200);
    break;


    default:
    json_output(403);
   
        break;
}
