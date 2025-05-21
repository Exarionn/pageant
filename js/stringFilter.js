$(document).ready(function() {
    $('.filter').on('input', function() {
        var value = this.value;
        value = value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
        this.value = value;
    });

        $('.judge').on('input', function() {
        var value = this.value;
        
        // Retrieve the percentage value
        var percentage = $(this).data('percent'); 
        console.log("Percentage attribute:", percentage);
        
        // Ensure that the entered value is within the allowed range
        value = value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
        if(parseFloat(value) < 1.00) {
            value = '1.00'; // Set the minimum score to 1.00
        } else if(parseFloat(value) > percentage) {
            value = percentage.toString(); // Set the value to the maximum allowed score
        }
        
        this.value = value;
    });
});