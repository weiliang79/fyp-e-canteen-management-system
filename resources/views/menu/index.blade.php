@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-3">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Filter') }}
                        </div>

                        <div class="card-body">

                              <form action="#" method="get">

                                    <div class="mb-3">
                                          <h6>{{ __('Store') }}</h6>

                                          <ul class="list-group">
                                                @if($allStores->count() == 0)
                                                <p class="mb-0 text-warning"><i class="fa-solid fa-triangle-exclamation"></i>{{ __(' There are no stores in this system right now.') }}</p>
                                                @else
                                                @foreach($allStores as $store)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      <div>
                                                            <input class="form-check-input me-1" type="checkbox" name="stores[]" value="{{ $store->id }}" {{ Request::get('stores') ? (in_array($store->id, Request::get('stores')) ? 'checked' : '') : '' }}>
                                                            <img src="{{ $store->logo_path ? asset($store->logo_path) : asset('/storage/defaults/store.png') }}" alt="{{ $store->name }}" title="{{ $store->description }}" style="width: 20px; height: 20px;">
                                                            {{ $store->name }}
                                                      </div>
                                                      <span class="badge bg-primary rounded-pill">{{ $store->products()->count() }}</span>
                                                </li>
                                                @endforeach
                                                @endif
                                          </ul>
                                    </div>

                                    <div class="mb-3">
                                          <h6>{{ __('Category') }}</h6>

                                          <ul class="list-group">
                                                @if($allStores->count() == 0)
                                                <p class="mb-0 text-warning"><i class="fa-solid fa-triangle-exclamation"></i>{{ __(' There are no food categories in this system right now.') }}</p>
                                                @else
                                                @foreach($allCategories as $category)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      <div>
                                                            <input class="form-check-input me-1" type="checkbox" name="categories[]" value="{{ $category->id }}" {{ Request::get('categories') ? (in_array($category->id, Request::get('categories')) ? 'checked' : '') : '' }}>
                                                            {{ $category->name }}
                                                      </div>
                                                      <span class="badge bg-primary rounded-pill">{{ $category->products()->count() }}</span>
                                                </li>
                                                @endforeach
                                                @endif
                                          </ul>
                                    </div>

                                    <button class="btn btn-primary" type="submit">{{ __('Apply Filter') }}</button>

                              </form>

                        </div>
                  </div>
            </div>

            <div class="col-9">
                  <div class="card">
                        <div class="card-header">
                              {{ __('Menu') }}
                        </div>

                        <div class="card-body">

                              @if($allStores->count() == 0)
                              <p class="mb-0 text-warning text-center"><i class="fa-solid fa-triangle-exclamation"></i>{{ __(' There are no stores in this system right now.') }}</p>
                              @else
                              @foreach($allStores as $store)
                              <div class="container-fluid mb-3">
                                    <div class="d-flex align-items-center">
                                          <img src="{{ $store->logo_path ? asset($store->logo_path) : asset('/storage/defaults/store.png') }}" alt="{{ $store->name }}" title="{{ $store->description }}" style="width: 35px; height: 35px;">
                                          <h5 class="mb-0 ms-2">{{ $store->name }}</h5>
                                    </div>
                                    @if($products->contains('store_id', $store->id))
                                    <div class="row row-cols-auto">

                                          @foreach($products->where('store_id', $store->id) as $product)
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="{{ $product->media_path ? asset($product->media_path) : asset('storage/defaults/product.png') }}" alt="{{ $product->name }}" title="{{ $product->description }}">
                                                      </div>
                                                      <div class="card-body d-flex flex-column">
                                                            <h6 class="card-title mb-1">{{ $product->name }}</h6>
                                                            <p class="mb-1 flex-grow-1">Start at: {{ config('payment.currency_symbol') }}{{ $product->price }}</p>
                                                            <button type="button" class="btn btn-primary" onclick="foodButtonClicked(this);" data-id="{{ $product->id }}">Show Details</button>
                                                      </div>
                                                </div>
                                          </div>
                                          @endforeach
                                    </div>
                                    @else
                                    <div class="row justify-content-center">
                                          <div class="col-auto">
                                                <p>{{ __('No Product found.') }}</p>
                                          </div>
                                    </div>
                                    @endif

                              </div>
                              @endforeach
                              @endif
                        </div>
                  </div>
            </div>
      </div>
</div>

<template id="options_templates">
      <div class="container">
            <div class="row row-cols-auto">
                  <h5 class="col">option_name</h5>
            </div>
            <div class="row row-cols-auto mb-2">

                  option_field

            </div>
      </div>
</template>

<template id="details_templates">
      <div class="col form-check form-check-inline">
            <input class="form-check-input" type="radio" id="id" name="name" value="value" checked>
            <label class="form-check-label" for="">detail_name</label>
      </div>
</template>

<template id="note_template">
      <div class="container">
            <div class="row row-cols-auto">
                  <h5 class="col">Note</h5>
                  <textarea class="form-control col" name="note" id="note" cols="10" rows="2"></textarea>
            </div>
      </div>
</template>

<script>
      function foodButtonClicked(item) {
            SwalWithBootstrap.fire({
                  title: 'Loading',
            });
            SwalWithBootstrap.showLoading();

            axios.post(
                        '{{ route("student.menus.get_product_options") }}', {
                              id: $(item).data('id'),
                        })
                  .then(function(response) {
                        console.log(response.data);

                        let htmlResult = '';
                        let html = $('#options_templates').html();

                        for (let i = 0; i < response.data.options.length; i++) {
                              htmlResult = htmlResult + html.replace('option_name', response.data.options[i].name);
                              let temp = '';
                              for (let j = 0; j < response.data.details.length; j++) {
                                    if (response.data.details[j].product_option_id === response.data.options[i].id) {
                                          let detailHtml = $('#details_templates').html();
                                          detailHtml = detailHtml.replace('id="id"', 'id="option' + response.data.options[i].id + '"');
                                          detailHtml = detailHtml.replace('name="name"', 'name="' + response.data.options[i].id + '"');
                                          detailHtml = detailHtml.replace('value="value"', 'value="' + response.data.details[j].id + '"');
                                          detailHtml = detailHtml.replace('detail_name', response.data.details[j].name + ' +{{ config("payment.currency_symbol") }}' + response.data.details[j].extra_price);

                                          if (response.data.details[j].name !== 'None') {
                                                detailHtml = detailHtml.replace('checked', '');
                                          }

                                          temp = temp + detailHtml;
                                    }
                              }
                              htmlResult = htmlResult.replace('option_field', temp);
                        }

                        let noteHtml = $('#note_template').html();

                        SwalWithBootstrap.fire({
                              title: response.data.product.name,
                              imageWidth: 300,
                              imageHeight: 200,
                              imageUrl: response.data.product.media_path === null ? '{{ asset("storage/defaults/product.png") }}' : '{{ Request::root() }}/' + response.data.product.media_path,
                              html: '<p>' + response.data.product.description + '</p><p>{{ config("payment.currency_symbol") }}' + response.data.product.price + '</p>' + htmlResult + noteHtml,
                              showCancelButton: true,
                              reverseButtons: true,
                              confirmButtonText: 'Add to cart',
                              cancelButtonText: 'Cancel',
                              preConfirm: () => {
                                    let note = SwalWithBootstrap.getPopup().querySelector('#note').value;
                                    let data = {
                                          product_id: response.data.product.id,
                                          note: note,
                                          options: [],
                                    };

                                    for (i = 0; i < response.data.options.length; i++) {
                                          let input = SwalWithBootstrap.getPopup().querySelector('#option' + response.data.options[i].id + ':checked').value;
                                          data.options.push({
                                                [response.data.options[i].id]: input,
                                          });
                                    }
                                    return data;
                              },
                        }).then((swalResult) => {

                              if (swalResult.isConfirmed) {
                                    axios.post(
                                                '{{ route("student.menus.add_cart") }}',
                                                swalResult.value
                                          )
                                          .then(function(response1) {
                                                SwalWithBootstrap.fire({
                                                      title: 'Success',
                                                      html: response1.data,
                                                      icon: 'success',
                                                }).then((result) => {
                                                      window.location.reload();
                                                });
                                          })
                                          .catch(function(error1) {
                                                console.log(error1);
                                                SwalWithBootstrap.fire({
                                                      title: 'Error',
                                                      html: error1.message,
                                                      icon: 'error',
                                                }).then((result) => {
                                                      window.location.reload();
                                                });
                                          });
                              }

                        });
                  })
                  .catch(function(error) {
                        console.log(error);
                        SwalWithBootstrap.fire({
                              title: 'Error',
                              html: error.message,
                              icon: 'error',
                        }).then((result) => {
                              window.location.reload();
                        });
                  });

      }
</script>

@endsection