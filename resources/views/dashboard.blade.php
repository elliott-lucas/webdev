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
        <input type="file" id="file" ref="file" @change="previewImage">
        <button @click="createPost">Post</button>

        <ul> <li v-for="post in posts">
            </br> 
            <p><b>@{{ post.user_id }}</b></p>
            <p>@{{ post.text }}</p>
            <a :href="/post/ + post.id">View Comments</a>
            </br> 
        </li> </ul> 
    </div>

    <script>
        var app = new Vue({
            el: "#root",
            data: {
                posts: [],
                newPostText: '',
                newPostImage: '',
            },
            methods: {
                createPost:function() {
                    let formData = new FormData();

                    formData.append('text', this.newPostText);

                    if (this.newPostImage) {
                        formData.append('image', this.newPostImage);
                    }

                    axios.post("{{route('api.posts.store')}}",
                        formData,
                        {
                            headers: {'Content-Type': 'multipart/form-data'}
                        }
                    )
                    .then(response=>{
                        this.posts.push(response.data);
                        this.newPostText = '';
                    })
                    .catch(response=>{
                    console.log(response);
                    })
                },

                previewImage(event) {
                    this.newPostImage = event.target.files[0];
                    console.log(this.newPostImage);
                }

            },
            mounted() {
                
                axios.get("{{route('api.posts.index')}}")
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