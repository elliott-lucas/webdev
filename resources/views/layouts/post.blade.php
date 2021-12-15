@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('View Post') }}
    </h2>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="root">
        <p><b>@{{ post.user_id }}</b></p>
        <p>@{{ post.text }}</p>

        </br>

        <ul> <li v-for="comment in comments"> 
            <p><b>@{{ comment.user_id }}</b></p>
            <p>@{{ comment.text }}</p>
            </br> 
        </li> </ul>
        
        <input type="text" maxlength="255" id="input" v-model="newCommentText">
        <button @click="createComment">Post</button>
    </div>

    <script>
        var app = new Vue({
            el: "#root",
            data: {
                post: '',
                comments: [],
                newCommentText: '',
            },
            methods: {
                createComment:function() {
                    axios.post("{{route('api.comments.store')}}",
                    {
                        text: this.newCommentText,
                        post_id:{{ $id }}
                    })
                    .then(response=>{
                        this.comments.push(response.data);
                        this.newCommentText = '';
                    })
                    .catch(response=>{
                    console.log(response);
                    })
                },
            },
            mounted() {
                
                axios.get("{{route('api.posts.specific', $id)}}")
                .then(response=>{
                    this.post = response.data;
                    axios.get("{{route('api.comments.specific', $id)}}")
                    .then(response=>{
                        this.comments = response.data;
                    })
                    .catch(response=>{
                        console.log(response);
                    })
                })
                .catch(response=>{
                    console.log(response);
                    console.log(this.post.user_id);
                })
            }

            
        });
    </script>
    
@endsection