<?php
session_start();
function get_producto()
{


  $productos= require'products.php';
  return $productos;
}

function get_product_by_id($id)
{
  $producto=get_producto();
  foreach($producto as $i =>$v)
  {
    if ($v['id']==$id)
     {
      return $producto[$i];
    }
  }
return false;
}

function get_card()
{
  if (isset($_SESSION['cart']))
  {
      $_SESSION['cart']['cart_total']=calcular_total();
     return $_SESSION['cart'];
  }
  $cart= 
  [
    'producto'       => [],
    'cart_total'=>calcular_total()
  
  ];

  $_SESSION['cart']=$cart;
  return $_SESSION['cart'];
}

function calcular_total()
{ 
  //el carro no existe se inicializa
  //si no hay producto pero el carrito si exite
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['producto']))
 {
  $cart_total= 
  [
    'envio'=>0,
    'subtotal'=>0,
    'total'=>0,
  ];
  return  $cart_total;
  }
  // calcular los totales segun los productos en el carro
  {
    $subTotal=0;
    $envio=100;
    $total=0;

// si hay productos y debo sumar las cantidades


    foreach ($_SESSION['cart']['producto'] as $p)
    {
     $_total =$p['cantidad'] * $p['precio'];
      $subTotal=$subTotal +$_total;
    }
    $total=$subTotal+$envio;
    $cart_total= 
    [
      'envio'=>$envio,
      'subtotal'=>$subTotal,
      'total'=>$total
    ];
    return  $cart_total;

  }
}

function json_output($status=200,$msg='',$data=[] )
{ 
  http_response_code($status);
  $repuesta=
  [ 
    'status'=>$status,
    'msg'=>$msg,
    'data'=>$data
  ];
  echo json_encode($repuesta);
  die;
   
}

function add_to_cart($id_producto,$cantidad=1)
{
  $new_producto=
  [
    'id'=>null,
    'clave'=>null,
    'nombre'=>null,
    'imagen'=>null,
    'precio'=>null,
    'cantidad'=>null
  ];
  $producto= get_product_by_id($id_producto);
 // algo paso o el producto no existe
  if (!$producto)
   {
   return false;
  }

  $new_producto=
  [
    'id'=>$producto['id'],
    'cantidad'=>$cantidad,
    'clave'=>$producto['clave'],
    'nombre'=>$producto['nombre'],
    'precio'=>$producto['precio'],
    'imagen'=>$producto['imagen'] 
  ];
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['producto']))
 {
  $_SESSION['cart']['producto'][]=$new_producto;
  return  true;
 }

 foreach($_SESSION['cart']['producto'] as $i => $p)
 {
  if ($p['id']===$id_producto) 
  {
    $_cantidad = $p['cantidad'] + $cantidad;
    $p['cantidad'] = $_cantidad;
    $_SESSION['cart']['producto'][$i] = $p;
    return true;
  }
    
  }
  $_SESSION['cart']['producto'][]=$new_producto;
  return true;
 
}

function borrar_elemento_carro($id_producto)
{
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['producto'])) {
   return false; 
  }
  foreach($_SESSION['cart']['producto'] as $i => $p)
  {
   if ($p['id']===$id_producto) 
   {
     unset($_SESSION['cart']['producto'][$i]);
     return true;
   }
  }
}
 function destroy_cart()
 {
   unset($_SESSION['cart']);
   return true;
 }

 function updateCarro($id_producto,$cantidad=1)
 {
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['producto']))
  {
   return  false;
  }
 
  foreach($_SESSION['cart']['producto'] as $i => $p)
  {
   if ($p['id']===$id_producto) 
   {
     $p['cantidad'] = (int)$cantidad;
     $_SESSION['cart']['producto'][$i] = $p;
     return true;
   }
    
   return false;
   }
 }

 
