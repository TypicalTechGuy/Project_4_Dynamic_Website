    document.querySelectorAll('.article-content h2').forEach((desc) => {
    desc.textContent = truncateText(desc.textContent, 130);
  });

  document.querySelectorAll('.article-content p').forEach((desc) => {
    desc.textContent = truncateText(desc.textContent, 200);
  });

const articles = document.querySelectorAll('.article-grid');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

let currentPage = 1;
const itemsPerPage = 2;

function showPage(page) {
  articles.forEach((section, index) => {
    section.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'grid' : 'none';
  });

  prevBtn.disabled = page === 1;
  nextBtn.disabled = page === Math.ceil(articles.length / itemsPerPage);
}

prevBtn.addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    showPage(currentPage);
  }
});

nextBtn.addEventListener('click', () => {
  if (currentPage < Math.ceil(articles.length / itemsPerPage)) {
    currentPage++;
    showPage(currentPage);
  }
});

showPage(currentPage);