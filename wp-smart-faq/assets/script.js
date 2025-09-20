document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.smart-faq li').forEach(function(item) {
        item.addEventListener('click', function() {
            let answer = this.querySelector('p');
            if(answer){
                if(answer.style.display === 'block'){
                    answer.style.display = 'none';
                    this.classList.remove('active');
                } else {
                    answer.style.display = 'block';
                    this.classList.add('active');
                }
            }
        });
    });
});
