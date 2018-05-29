@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.fileuploader.css')}}">
    <script src="{{asset('js/jquery.fileuploader.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('input#images').fileuploader({
                limit: 15,
                extensions: ['jpg', 'jpeg', 'png', 'gif']
            });
            $('input#image_general').fileuploader({
                limit: 1,
                extensions: ['jpg', 'jpeg', 'png', 'gif']
            });
        })
    </script>
    <div class="ui container">
        <div class="ui grid">
            <div class="column">
                <div class="ui mini breadcrumb">
                    <a class="section">Home</a>
                    <i class="right chevron icon divider"></i>
                    <a class="section">New Product</a>
                </div>
            </div>
        </div>
        <div class="ui stackable grid">

            <div class="column sidebar">
                @include('inc.account-sidebar', ['active' => 'create-product'])
            </div>

            <div class="page-conent column">
                @if ($errors->all())
                    <div class="ui error message">
                        <ul class="list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="ui info message">
                        <ul class="list">
                            <li>{{ session()->get('message') }}</li>
                        </ul>
                    </div>
                @endif

                <div class="ui top attached tabular menu tabs">
                    <a class="active item" data-tab="general">General</a>
                    <a class="item" data-tab="attributes">Attributes</a>
                    <a class="item" data-tab="images">Images</a>
                </div>
                <form class="ui form error no-border" enctype="multipart/form-data" method="post"  action="{{ route('products.update', ["id" => $product->id]) }}">
                    <div class="ui bottom attached active tab segment" data-tab="general">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put"/>
                        <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                            <label>Product name *</label>
                            <div class="ui left icon input">
                                <input placeholder="Product name" type="text" name="name" value="{{ $product->name }}" required>
                                <i class="shopping bag icon"></i>
                            </div>
                        </div>
                        <div class="field {{ $errors->has('description') ? 'error' : '' }}">
                            <label>Product description *</label>
                            <div class="ui left icon input">
                                <textarea placeholder="Product description" name="description"  required>{{ $product->description }}</textarea>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field {{ $errors->has('stock') ? 'error' : '' }}">
                                <label>Stock *</label>
                                <div class="ui left icon input">
                                    <i class="cubes icon"></i>
                                    <input placeholder="Stock" type="text" name="stock" value="{{ $product->stock }}"  required>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field {{ $errors->has('regular_price') ? 'error' : '' }}">
                                <label>Product regular price *</label>
                                <div class="ui left icon input">
                                    <i class="money icon"></i>
                                    <input placeholder="Regular price" type="text" name="regular_price" value="{{ $product->regular_price }}"  required>
                                </div>
                            </div>
                            <div class="field {{ $errors->has('sale_price') ? 'error' : '' }}">
                                <label>Product sale price</label>
                                <div class="ui left icon input">
                                    <i class="money icon"></i>
                                    <input placeholder="Sale price" type="text" name="sale_price" value="{{ $product->sale_price }}"  >
                                </div>
                            </div>
                            <div class="field {{ $errors->has('currency') ? 'error' : '' }}">
                                <label>Currency *</label>
                                <div class="ui selection dropdown">
                                    <input name="currency" type="hidden" value="{{ $product->currency }}" required>
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Currency</div>
                                    <div class="menu">
                                        <div class="item" data-value="usd"> <i class="united states flag"></i> (USD) American Dollar</div>
                                        <div class="item" data-value="amd"> <i class="armenia flag"></i> (AMD) Armenian Dram</div>
                                        <div class="item" data-value="rub"> <i class="russia flag"></i> (RUB) Russian Rouble</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field {{ $errors->has('categories') ? 'error' : '' }}">
                            <label>Product Categories</label>
                            <div class="ui left icon input">
                                <select class="ui fluid search dropdown" multiple="" name="categories[]">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if(in_array($category->id, $product->categories->pluck("id")->all())) selected="selected" @endif>{{$category->category_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="ui bottom attached tab segment" data-tab="attributes">
                        <div class="field {{ $errors->has('colors') ? 'error' : '' }}">
                            <label>Product color variations</label>
                            <div class="ui left icon input">
                                <select class="ui fluid search dropdown" multiple="" name="colors[]">
                                    @foreach($colors as $color)
                                        <option value="{{$color->id}}"
                                                @if(in_array($color->id, $product->colors->pluck("id")->all())) selected="selected" @endif>{{$color->color_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="field {{ $errors->has('tags') ? 'error' : '' }}">
                            <label>Product tags</label>
                            <div class="ui left icon input">
                                <select class="ui fluid search dropdown" multiple="" name="tags[]">
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}"
                                                @if(in_array($tag->id, $product->tags->pluck("id")->all())) selected="selected" @endif>{{$tag->tag_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field {{ $errors->has('weight') ? 'error' : '' }}">
                                <label>Weight</label>
                                <div class="ui left icon input right labeled">
                                    <i class="cube icon"></i>
                                    <input placeholder="Weight" type="text" name="weight" value="{{ $product->weight}}"  >
                                    <div class="ui label">
                                        gr.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="field {{ $errors->has('length') ? 'error' : '' }}">
                                <label>Length</label>
                                <div class="ui left icon input right labeled">
                                    <i class="resize horizontal icon"></i>
                                    <input placeholder="Length" type="text" name="length" value="{{ $product->length }}"  >
                                    <div class="ui label">
                                        cm.
                                    </div>
                                </div>
                            </div>
                            <div class="field {{ $errors->has('width') ? 'error' : '' }}">
                                <label>Width</label>
                                <div class="ui left icon input right labeled">
                                    <i class="resize vertical icon"></i>
                                    <input placeholder="Width" type="text" name="width" value="{{ $product->width }}"  >
                                    <div class="ui label">
                                        cm.
                                    </div>
                                </div>
                            </div>
                            <div class="field {{ $errors->has('height') ? 'error' : '' }}">
                                <label>Height</label>
                                <div class="ui left icon input right labeled">
                                    <i class="resize horizontal icon"></i>
                                    <input placeholder="Height" type="text" name="height" value="{{ $product->height }}"  >
                                    <div class="ui label">
                                        cm.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui bottom attached tab segment" data-tab="images">
                        <div class="field {{ $errors->has('images') ? 'error' : '' }}">
                            <label>Product general image *</label>
                            <div class="ui left icon input">
                                <input placeholder="Images" type="file" value="{{old("images[]")}}" name="images[]" id="image_general" accept="image/*">
                            </div>
                            <label>Other images</label>
                            <div class="ui left icon input">
                                <input placeholder="Images" type="file" value="{{old("images[]")}}" name="images[]" multiple id="images" accept="image/*">
                            </div>
                        </div>
                        <div class="fileuploader-items">
                            <ul class="fileuploader-items-list" id="product_old_images">
                                @foreach($product->images as $image)
                                    <div class="old-image">
                                        <input type="hidden" value="{{$image->id}}" name="old_images[]">
                                        <li class="fileuploader-item file-type-image file-ext-jpeg">
                                            <div class="columns">
                                                <div class="column-thumbnail">
                                                    <div class="fileuploader-item-image">
                                                        <img src="{{$image->file}}" height="36" width="36" alt="">
                                                    </div>
                                                </div>
                                                <div class="column-title">
                                                    <div title="2.jpeg">{{ basename($image->file) }}</div>
                                                    <span> KB</span>
                                                </div>
                                                <div class="column-actions">
                                                    <a class="fileuploader-action fileuploader-action-remove" title="Remove"><i></i></a>
                                                </div>
                                            </div>
                                            <div class="progress-bar2"><span></span></div>
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    <button class="ui button primary"><i class="save icon"></i> Save Product</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('.ui.checkbox').checkbox({
                onIndeterminate: function () {
                    alert('onEnable');
                },
                onChecked: function () {
                    var value = $(this).attr('id');
                    $('.pay-type.' + value).show();
                },
                onUnchecked: function () {
                    var value = $(this).attr('id')
                    $('.pay-type.' + value).hide();

                }
            });
        })
    </script>
@endsection

@section('footer')
    @parent
@endsection