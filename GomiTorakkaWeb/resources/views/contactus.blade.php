<!DOCTYPE html>
<html lang="en" data-theme="emerald">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - GomiTorakka - Smart Waste Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Styles / Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

   
</head>

<body class="animate-fade-in">
    @include('layouts.navbar')
  <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h1 class="card-title text-3xl font-bold mb-6">Contact Us</h1>
                    <p class="mb-8 text-gray-600">Have questions or feedback? Fill out the form below and we'll get back to you as soon as possible.</p>
                    
                    <form 
                        action="https://formsubmit.co/yanuarbp2@gmail.com" 
                        method="POST"
                        class="space-y-6"
                        >
                        <!-- CC the second email -->
                        <input type="hidden" name="_cc" value="jackganma@gmail.com">
                        <!-- Disable captcha -->
                        <input type="hidden" name="_captcha" value="false">
                        <!-- Success redirect -->
                        <input type="hidden" name="_next" value="http://127.0.0.1:8000/contact">
                        
                        <div class="form-control">
                            <label class="label" for="name">
                                <span class="label-text">Your Name</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                placeholder="John Doe" 
                                class="input input-bordered w-full" 
                                required
                            >
                        </div>
                        
                        <div class="form-control">
                            <label class="label" for="email">
                                <span class="label-text">Email Address</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                placeholder="your@email.com" 
                                class="input input-bordered w-full" 
                                required
                            >
                        </div>
                        
                        <div class="form-control">
                            <label class="label" for="subject">
                                <span class="label-text">Subject</span>
                            </label>
                            <input 
                                type="text" 
                                id="subject" 
                                name="subject" 
                                placeholder="What's this about?" 
                                class="input input-bordered w-full" 
                                required
                            >
                        </div>
                        
                        <div class="form-control">
                            <label class="label" for="message">
                                <span class="label-text">Your Message</span>
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5" 
                                class="textarea textarea-bordered w-full" 
                                placeholder="Type your message here..." 
                                required
                            ></textarea>
                        </div>
                        
                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')

  


</body>
</html>