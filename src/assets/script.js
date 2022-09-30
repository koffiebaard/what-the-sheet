let show_dialog_save=document.querySelector('button.save');
let show_dialog_share=document.querySelector('button.share');

let modal_save=document.querySelector('dialog.save');
let modal_share=document.querySelector('dialog.share');

let save=document.querySelector('dialog.save > button');
let close_share=document.querySelector('dialog.share > button');

show_dialog_save.addEventListener('click', () => {
  hide_notices();
  modal_save.showModal();
});

show_dialog_share.addEventListener('click', () => {
  modal_share.showModal();
});

save.addEventListener('click', async() => {
  sheet_id = document.querySelector('#sheet').dataset.id

  sheet = {
    name: document.querySelector('input[name=name]').value,
    race: document.querySelector('input[name=race]').value,
    class: document.querySelector('input[name=class]').value,
  };

  // Update sheet
  if (sheet_id) {
    console.log(`Updating sheet ${sheet_id}`);
    response = await update_sheet(sheet_id, sheet);

    if (response && response.id) {
      show_notice_success();
      setTimeout(() => {
        modal_save.close();
      }, 500);
    } else {
      show_notice_fail();
      console.log(response);
    }
  // Create sheet
  } else {
    console.log(`Creating sheet`);
    response = await create_sheet(sheet);
    console.log(response);

    if (response && response.id) {
      show_notice_success();
      setTimeout(() => {
        window.location.href = `/${response.id}`
      }, 500);
    } else {
      show_notice_fail();
      console.log(response);
    }
  }
})

close_share.addEventListener('click', async() => {
  modal_share.close();
});

function show_notice_success() {
  document.querySelector('dialog .notice.success').style.display = "block";
}

function show_notice_fail() {
  document.querySelector('dialog .notice.fail').style.display = "block";
}

function hide_notices() {
  document.querySelector('dialog .notice').style.display = "none";
}

async function create_sheet(data = {}) {
  const response = await fetch('/api/sheet', {
    method: 'POST',
    mode: 'cors',
    cache: 'no-cache',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  });
  return response.json();
}

async function update_sheet(id, data = {}) {
  const response = await fetch(`/api/sheet/${id}`, {
    method: 'PUT',
    mode: 'cors',
    cache: 'no-cache',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  });
  return response.json();
}
