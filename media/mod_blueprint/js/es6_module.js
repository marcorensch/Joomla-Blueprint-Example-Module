// Example of ES6 module

class ES6Module {

    $value = null;
    constructor($value= null) {
        console.log('ES6 module loaded');
        this.$value = $value;
    }

    init() {
        console.log('ES6 module initialized with value: ' + this.$value);
    }
}

export { ES6Module }