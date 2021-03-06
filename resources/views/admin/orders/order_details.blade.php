<?php use App\Models\Product; ?>

@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            @if(Session::has('success_message'))
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
                {{ Session::forget('success_message') }}
            @endif
            <div class="col-sm-6">
                <h1>Commandes</h1>
            </div>
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Commande numéro {{ $orderDetails['id'] }}</li>
                    </ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Détails de la commande</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Date</td>
                            <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                        </tr>
                        <tr>
                            <td>Statut</td>
                            <td>{{ $orderDetails['order_status'] }}</td>
                        </tr>
                        @if(!empty($orderDetails['courrier_name']))
                        <tr>
                            <td>Nom du courrier</td>
                            <td>{{ $orderDetails['courrier_name'] }}</td>
                        </tr>
                        @endif
                        @if(!empty($orderDetails['tracking_number']))
                        <tr>
                            <td>Numéro de suivi</td>
                            <td>{{ $orderDetails['tracking_number'] }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Total</td>
                            <td>{{ $orderDetails['grand_total'] }} Fcfa</td>
                        </tr>
                        <tr>
                            <td>Taxes</td>
                            <td>{{ $orderDetails['shipping_charges'] }} Fcfa</td>
                        </tr>
                        @if(!empty($orderDetails['coupon_code']))
                        <tr>
                            <td>Coupon code</td>
                            <td>{{ $orderDetails['coupon_code'] }}</td>
                        </tr>
                        @endif
                        @if(!empty($orderDetails['coupon_amount']))
                        <tr>
                            <td>Montant du coupon</td>
                            <td>{{ $orderDetails['coupon_amount'] }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Méthode de paiement</td>
                            <td>{{ $orderDetails['payment_method'] }}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Adresse de livraison</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nom</td>
                            <td>{{ $orderDetails['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Adresse</td>
                            <td>{{ $orderDetails['address'] }}</td>
                        </tr>
                        <tr>
                            <td>Nom</td>
                            <td>{{ $orderDetails['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Numéro de téléphone</td>
                            <td>{{ $orderDetails['mobile'] }}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Détails du client</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-bordered">
                      <tbody>
                          <tr>
                              <td>Nom</td>
                              <td>{{ $userDetails['name'] }}</td>
                          </tr>
                          <tr>
                              <td>Adresse e-mail</td>
                              <td>{{ $userDetails['email'] }}</td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Mettre a jour le statut de la commande</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-bordered">
                      <tbody>
                          <tr>
                              <td colspan="2">
                                <form action="{{ url('admin/update-order-status') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                                    <select name="order_status" id="order_status" required>
                                        <option>Sélectionner le statut</option>
                                        @foreach ($orderStatuses as $status)
                                        <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status'] == $status['name']) selected @endif>{{ $status['name'] }}</option>
                                        @endforeach
                                    </select> &nbsp;&nbsp;
                                    <input style="width: 120px" type="text" name="courrier_name" @if(empty($orderDetails['courrier_name'])) id="courrier_name" @endif value="{{ $orderDetails['courrier_name'] }}" placeholder="courrier">
                                    <input style="width: 120px" type="text" name="tracking_number" @if(empty($orderDetails['tracking_number'])) id="tracking_number" @endif value="{{ $orderDetails['tracking_number'] }}" placeholder="numéro de suivi" >
                                    <button type="submit">Mettre à jour</button>
                                </form>
                              </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                                @foreach ($orderLog as $log)
                                    <strong>{{ $log['order_status'] }}</strong><br>
                                   {{ date('F j Y, à H:i:s',strtotime($log['created_at'])) }}
                                   <hr><br>
                                @endforeach
                            </td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Produits commandés</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>Photo</th>
                        <th>Numéro du produit</th>
                        <th>Nom du produit</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Quantité</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails['orders_products'] as $product)
                        <tr>
                            <td><?php $getProductImage=Product::getProductImage($product['product_id'])
                             ?>
                             <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width: 80px" src="{{ $getProductImage }}" alt=""></a>

                             </td>
                            <td>{{ $product['product_code'] }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['product_size'] }}</td>
                            <td>{{ $product['product_color'] }}</td>
                            <td>{{ $product['product_qty'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
</div>

@endsection
