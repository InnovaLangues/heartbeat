socket.on('serverUpdate', function (data) {
    //toastr.success('server update')

    var server = JSON.parse(data)

    //console.log(server);

    // CPU
    var cpuIcon = $('.info-box-cpu-icon');
    var cpuIconI = $('.info-box-cpu-icon i');
    var loadPercent = (server.cpu.load.min1 / server.cpu.count);

    cpuIcon.removeClass('bg-red bg-orange bg-green');
    cpuIconI.removeClass('fa-thumbs-o-down fa-thumbs-o-up');

    if (loadPercent > 0.8) {
    	cpuIcon.addClass('bg-red');
    	cpuIconI.addClass('fa-thumbs-o-down');
    } else if (loadPercent > 0.5) {
    	cpuIcon.addClass('bg-orange');
    	cpuIconI.addClass('fa-thumbs-o-up');
    } else {
    	cpuIcon.addClass('bg-green');
    	cpuIconI.addClass('fa-thumbs-o-up');
    };

    $('.cpu-count').html(server.cpu.count);
    $('.cpu-load-min1').html(server.cpu.load.min1);
    $('.cpu-load-min5').html(server.cpu.load.min5);
    $('.cpu-load-min15').html(server.cpu.load.min15);
    $('.cpu-cores-percent-used').html( (server.cpu.load.min1 / server.cpu.count) + " %");
    
    // MEMORY
    var memoryIcon = $('.info-box-memory-icon');
    var memoryIconI = $('.info-box-memory-icon i');
    var memoryPercentUsed = (server.memory.used / server.memory.total);

    memoryIcon.removeClass('bg-red bg-orange bg-green');
    memoryIconI.removeClass('fa-thumbs-o-down fa-thumbs-o-up');

    if (memoryPercentUsed > 0.8) {
    	memoryIcon.addClass('bg-red');
    	memoryIconI.addClass('fa-thumbs-o-down');
    } else if (memoryPercentUsed > 0.5) {
    	memoryIcon.addClass('bg-orange');
    	memoryIconI.addClass('fa-thumbs-o-up');
    } else {
    	memoryIcon.addClass('bg-green');
    	memoryIconI.addClass('fa-thumbs-o-up');
    };

    $('.memory-total').html(bytesToSize(server.memory.total * 1024));
    $('.memory-used').html(bytesToSize(server.memory.used * 1024));
    $('.memory-free').html(bytesToSize(server.memory.free * 1024));
    $('.memory-percent-used').html( (server.memory.used / server.memory.total * 100 ).toFixed(0) + " %");
   
    // MEMORY - SWAP
    var memorySwapIcon = $('.info-box-memory-swap-icon');
    var memorySwapIconI = $('.info-box-memory-swap-icon i');
    var memoryPercentUsed = (server.memory.used / server.memory.total);

    memorySwapIcon.removeClass('bg-red bg-orange bg-green');
    memorySwapIconI.removeClass('fa-thumbs-o-down fa-thumbs-o-up');

    if (memoryPercentUsed < 0.8) {
    	memorySwapIcon.addClass('bg-red');
    	memorySwapIconI.addClass('fa-thumbs-o-down');
    } else if (memoryPercentUsed < 0.5) {
    	memorySwapIcon.addClass('bg-orange');
    	memorySwapIconI.addClass('fa-thumbs-o-up');
    } else {
    	memorySwapIcon.addClass('bg-green');
    	memorySwapIconI.addClass('fa-thumbs-o-up');
    };
    $('.memory-swap-total').html(bytesToSize(server.memory.swap.total * 1024));
    $('.memory-swap-used').html(bytesToSize(server.memory.swap.used * 1024));
    $('.memory-swap-free').html(bytesToSize(server.memory.swap.free * 1024));
    $('.memory-swap-percent-used').html( (server.memory.swap.used / server.memory.swap.total * 100 ).toFixed(0) + " %");
    
    // DISK
    var diskIcon = $('.info-box-disk-icon');
    var diskIconI = $('.info-box-disk-icon i');
    var diskPercentUsed = (server.disk.used / server.disk.total);

    diskIcon.removeClass('bg-red bg-orange bg-green');
    diskIconI.removeClass('fa-thumbs-o-down fa-thumbs-o-up');

    if (diskPercentUsed > 0.8) {
    	diskIcon.addClass('bg-red');
    	diskIconI.addClass('fa-thumbs-o-down');
    } else if (diskPercentUsed > 0.5) {
    	diskIcon.addClass('bg-orange');
    	diskIconI.addClass('fa-thumbs-o-up');
    } else {
    	diskIcon.addClass('bg-green');
    	diskIconI.addClass('fa-thumbs-o-up');
    };

    $('.disk-total').html(bytesToSize(server.disk.total * 1024));
    $('.disk-used').html(bytesToSize(server.disk.used * 1024));
    $('.disk-free').html(bytesToSize(server.disk.free * 1024));
    $('.disk-percent-used').html( (server.disk.used / server.disk.total * 100 ).toFixed(0) + " %");
});