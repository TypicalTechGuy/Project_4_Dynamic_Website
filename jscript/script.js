function truncateText(text, maxLength) {
    if (text.length <= maxLength) {
      return text;
    } else {
      return text.slice(0, maxLength) + "...";
    }
  }

  document.querySelectorAll('.related-item h3').forEach((title) => {
    title.textContent = truncateText(title.textContent, 60);
  });
  
  document.querySelectorAll('.related-item p').forEach((desc) => {
    desc.textContent = truncateText(desc.textContent, 100);
  });
  

document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.nav-links').classList.toggle('active');
});
