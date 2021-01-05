@extends('layouts.default')

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js" integrity="sha512-90vH1Z83AJY9DmlWa8WkjkV79yfS2n2Oxhsi2dZbIv0nC4E6m5AbH8Nh156kkM7JePmqD6tcZsfad1ueoaovww==" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    var vmdata = @json($data)
</script>
@endsection

@section('meta_title')
    Properties
@endsection

@section('content')
    <div id="app">
        <div id="search">
            @include('admin.includes.search')
        </div>
        <div id="main">
            @if(count($data['properties']) > 0)

                <ul class="list-group mt-20">
                    <li v-for="property in properties" style="margin:10px 0">
                        <a :href="getPropertyUrl(property.id)">@{{ property.description }}</a>
                        <br />Bedrooms: @{{ property.num_bedrooms }}
                        <br />Property type: @{{ property.property_type.title }}
                        <br />Price: @{{ property.price }}
                    </li>
                </ul>

                <div id="pagination">
                    Current page: @{{ pagination.current_page }} <br />
                    <!-- @TODO if current page > total pages count (after applying filter), reset that current page> -->
                    <span v-if="pagination.current_page > 1">
                        <label for="prev_page"><<</label>
                        <input type="radio" name="page" :value="pagination.current_page - 1" v-model="search.page" id="prev_page">
                    </span>
                    <span v-for="index in pagination.pages" :key="index">
                        <label :for="'p_' + index" >@{{ index }}</label>
                        <input type="radio" name="page" :value="index" v-model="search.page" :id="'p_' + index">
                    </span>
                    <span v-if="pagination.current_page < pagination.pages">
                        <label for="next_page">>></label>
                        <input type="radio" name="page" :value="pagination.current_page + 1" v-model="search.page" id="next_page">
                    </span>
                    <span v-if="pagination.current_page != pagination.pages">
                        <label for="last_page">Last page</label>
                        <input type="radio" name="page" :value="pagination.pages" v-model="search.page" id="last_page">
                    </span>

                    <br />Total properties: @{{ pagination.total_count }}
                </div>
            @endif
        </div>
    </div>
    <script src="/js/script.js"></script>
    <style>
        #pagination{margin-top:20px}
        input[type="radio"]:hover, label:hover{cursor:pointer}
        input[type="radio"] {margin-right:5px}
        .active{font-weight: bold}
    </style>
@endsection
