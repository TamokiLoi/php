@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Back To List Products</a>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0px;">Update Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.update',  ['id' => $product->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="name" name="name" placeholder="Enter name Product" value="{{ $product->name }}">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                id="code" name="code" placeholder="Enter code Product" value="{{ $product->code }}">
                            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" rows="5"
                                class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                placeholder="Enter content" style="resize: none;">{{ $product->content }}</textarea>
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="regular_price">Regular Price</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('regular_price') ? 'is-invalid' : '' }}"
                                id="regular_price" name="regular_price" placeholder="Enter Regular Price"
                                value="{{ $product->regular_price }}">
                            <div class="invalid-feedback">{{ $errors->first('regular_price') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="sale_price">Sale Price</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('sale_price') ? 'is-invalid' : '' }}"
                                id="sale_price" name="sale_price" placeholder="Enter Sale Price"
                                value="{{ $product->sale_price }}">
                            <div class="invalid-feedback">{{ $errors->first('sale_price') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="original_price">Original Price</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('original_price') ? 'is-invalid' : '' }}"
                                id="original_price" name="original_price" placeholder="Enter Original Price"
                                value="{{ $product->original_price }}">
                            <div class="invalid-feedback">{{ $errors->first('original_price') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" min="0"
                                class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" id="quantity"
                                name="quantity" placeholder="Enter Quantity" value="{{ $product->quantity }}">
                            <div class="invalid-feedback">{{ $errors->first('quantity') }}</div>
                        </div>

                        {{-- image --}}
                        <div class="form-group">
                            <label for="image" style="display: block;">Image</label>
                            <div>
                                @if (!empty($product->image) &&
                                file_exists(public_path(get_thumbnail("uploads/$product->image"))))
                                    <img src="{{ asset(get_thumbnail("uploads/$product->image")) }}" alt="image"
                                    class="img-fluid img-thumbnail" width="100" height="75">
                                @else
                                    <img src="{{ asset('images/no-img_thumb.jpg') }}" alt="no image"
                                    class="img-fluid img-thumbnail" width="100" height="75">
                                @endif
                            </div>
                            <br>
                            <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                id="image" name="image" value="{{ $product->image }}" style="height: 42px;">
                            <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                        </div>

                        {{-- upload library images --}}
                        {{-- {{ dd($product->attachments) }} --}}
                        <div class="form-group">
                            <label for="images">Library images product</label>
                            <div>
                                @forelse ($product->attachments as $file)
                                    @if (file_exists(public_path(get_thumbnail("uploads/$file->path"))))
                                        <img src="{{ asset(get_thumbnail("uploads/$file->path")) }}" alt="image"
                                        class="img-fluid img-thumbnail" width="100" height="75">
                                    @else
                                        <img src="{{ asset('images/no-img_thumb.jpg') }}" alt="no image"
                                        class="img-fluid img-thumbnail" width="100" height="75">
                                    @endif
                                @empty
                                @endforelse
                            </div>
                            <br>
                            <input type="file" class="form-control {{ $errors->has('images.*') ? 'is-invalid' : '' }}"
                                id="images" name="images[]" value="{{ old('images') }}" style="height: 42px;" multiple>
                            <div class="invalid-feedback">{{ $errors->first('images.*') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id"
                                class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                                @if (count($categories) > 0)
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select name="tags[]" id="tags" class="form-control select2" multiple>
                                @if ($product->tags)
                                @foreach($product->tags as $tag)
                                <option value="{{ $tag->name }}" selected>{{ $tag->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group" id="qh-app">
                            <qh-attributes></qh-attributes>
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-primary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Styles --}}
@section('head_styles')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

{{-- Scripts --}}
@section('body_scripts_top')
<script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $("#tags").select2({
        tags: true,
        tokenSeparators: [',']
    });
</script>
<script type="text/javascript">
    // check show old-image
    $("#showOldImage").hide();
    if ($("#showOldImage").attr('src').search('thumb') > -1) {
        $("#showOldImage").show();
    } 
</script>
<script type="text/x-template" id="qh-attributes-template">
    <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Attribute</th>
                    <th>Value</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, key) in attributes">
                    <td>
                        <input type="text" :name="'attributes['+ key +'][name]'" v-model="item.name" class="form-control" placeholder="Enter Attribute ">
                    </td>
                    <td>
                        <input type="text" :name="'attributes['+ key +'][value]'" v-model="item.value" class="form-control" placeholder="Enter Value ">
                    </td>
                    <td class="text-center">
                        <button type="button" v-if="key !== 0" v-on:click="deleteAttribute(item)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                        <button type="button" v-if="key == (attributes.length - 1)" v-on:click="addAttribute" class="btn btn-success"><i class="fas fa-plus"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>    
    </script>
<script type="text/javascript">
    Vue.component('qh-attributes', {
        template: '#qh-attributes-template',
        data: function() {
            var attributes = null;

            @if($product->attributes)
                attributes = {!! $product->attributes !!};
            @endif

            if(attributes == null || attributes.length == 0) {
                attributes = [
                    {name: '', value: ''}
                ];
            }
            return {
                attributes: attributes
            };
        },
        methods: {
            addAttribute: function () {
                this.attributes.push({name: '', value: ''});
                console.log(this.attributes)
            },
            deleteAttribute: function (item) {
                this.attributes.splice(this.attributes.indexOf(item), 1);
            },
        }
    });
    new Vue({
        el: '#qh-app'
    });
</script>
@endsection