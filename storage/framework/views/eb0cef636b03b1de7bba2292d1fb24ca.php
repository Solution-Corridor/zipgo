<!DOCTYPE html>
<html lang="en" class="<?php if(auth()->guard()->check()): ?> scroll-smooth <?php endif; ?>">

<head>
    <?php if(auth()->guard()->guest()): ?>
    <?php echo $__env->make('includes.header_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>Membership Plans</title>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>My Membership Plans</title>
    <?php endif; ?>
</head>

<body class="min-h-screen bg-[#0A0A0F] text-white">

    <?php if(auth()->guard()->guest()): ?>
    <main class="mx-auto max-w-md p-4 min-h-screen">

        <div class="paginacontainer"></div>

        <?php echo $__env->make('includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php endif; ?>


        <?php if(auth()->guard()->check()): ?>
        <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

            <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php endif; ?>

            <section>
                <div class="container mx-auto px-4 py-2">
                    <div class="text-center max-w-3xl mx-auto">
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            Membership <span class="text-primary">Plans</span>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-primary to-accent mx-auto"></div>
                        <p class="text-white/60 text-lg">
                            We have wide range of plans choose which suits your goals.
                        </p>
                    </div>

                    <div class="flex justify-center mb-1 w-full mt-5">

<div class="flex w-full bg-gray-900 rounded-2xl p-1 border border-gray-700 shadow-lg">
<button
class="tabBtn flex-1 px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-yellow-500 to-amber-700 rounded-xl transition-all duration-200 hover:scale-[1.02]"
data-tab="gold">
Gold
</button>

<button
class="tabBtn flex-1 px-4 py-3 text-sm font-semibold text-white rounded-xl transition-all duration-200 hover:scale-[1.02]"
data-tab="silver">
Silver
</button>


<button
class="tabBtn flex-1 px-4 py-3 text-sm font-semibold text-white rounded-xl transition-all duration-200 hover:scale-[1.02]"
data-tab="diamond">
Diamond
</button>

<!-- invest  -->
<button
class="tabBtn flex-1 px-4 py-3 text-sm font-semibold text-white rounded-xl transition-all duration-200 hover:scale-[1.02]"
data-tab="invest">
Invest
</button>

</div>

</div>

                    <div class="mb-20 tabContent hidden" id="silver">
                        <?php $__currentLoopData = $plans['silver']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('user.partials.package_plans', ['plan' => $plan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mb-20 tabContent" id="gold">
                        <?php $__currentLoopData = $plans['gold']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('user.partials.package_plans', ['plan' => $plan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mb-20 tabContent hidden" id="diamond">
                        <?php $__currentLoopData = $plans['diamond']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('user.partials.package_plans', ['plan' => $plan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mb-20 tabContent hidden" id="invest">
                        <?php $__currentLoopData = $plans['invest']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('user.partials.package_plans', ['plan' => $plan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>

            <?php if(auth()->guard()->guest()): ?>
            <?php echo $__env->make('includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
            <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>


    </main>

    <script>
document.querySelectorAll('.tabBtn').forEach(btn => {

    btn.addEventListener('click', function(){

        document.querySelectorAll('.tabBtn').forEach(b=>{
            b.classList.remove('bg-yellow-600')
        })

        document.querySelectorAll('.tabContent').forEach(tab=>{
            tab.classList.add('hidden')
        })

        this.classList.add('bg-yellow-600')

        document.getElementById(this.dataset.tab).classList.remove('hidden')

    })

})

document.querySelectorAll('.tabBtn').forEach(btn => {

btn.addEventListener('click', function(){

document.querySelectorAll('.tabBtn').forEach(b=>{
b.classList.remove(
'bg-gradient-to-r',
'from-gray-400','to-gray-600',
'from-yellow-500','to-amber-700',
'from-cyan-400','to-blue-600'
)
})

if(this.dataset.tab === 'silver'){
this.classList.add('bg-gradient-to-r','from-gray-400','to-gray-600')
}

if(this.dataset.tab === 'gold'){
this.classList.add('bg-gradient-to-r','from-yellow-500','to-amber-700')
}

if(this.dataset.tab === 'diamond'){
this.classList.add('bg-gradient-to-r','from-cyan-400','to-blue-600')
}

if(this.dataset.tab === 'invest'){
this.classList.add('bg-gradient-to-r','from-green-400','to-green-600')
}




})
})

</script>
</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/plans.blade.php ENDPATH**/ ?>