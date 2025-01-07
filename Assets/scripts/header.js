function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const content = document.querySelector('.content');
  const isCollapsed = sidebar.offsetWidth <= 90;
  
  if (isCollapsed) {
      sidebar.style.width = '260px';
      content.style.marginLeft = '260px';
      document.querySelectorAll('.sidebar__text').forEach(text => {
          text.style.visibility = 'visible';
          text.style.opacity = '1';
      });
  } else {
      sidebar.style.width = '90px';
      content.style.marginLeft = '90px';
      document.querySelectorAll('.sidebar__text').forEach(text => {
          text.style.visibility = 'hidden';
          text.style.opacity = '0';
      });
  }
}
