@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="root">
        <input type="text" maxlength="255" id="input" v-model="newPostText">
        <button @click="createPost">Post</button>

        <ul> <li v-for="post in posts"> 
            <p><b>@{{ post.user_id }}</b></p>
            <p>@{{ post.text }}</p>
            </br> 
        </li> </ul> 
    </div>

    <script>
        var app = new Vue({
            el: "#root",
            data: {
                posts: [],
                newPostText: '',
            },
            methods: {
                createPost:function() {
                    axios.post("{{route('api.post.store')}}",
                    {
                        text: this.newPostText,
                    })
                    .then(response=>{
                        this.posts.push(response.data);
                        this.newPostText = '';
                    })
                    .catch(response=>{
                    console.log(response);
                    })
                },
            },
            mounted() {
                
                axios.get("{{route('api.post.index')}}")
                .then(response=>{
                    this.posts = response.data;
                })
                .catch(response=>{
                    console.log(response);
                })
            }
        });
    </script>
@endsection