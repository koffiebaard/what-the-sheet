let show_dialog_save=document.querySelector('button.open_save');
let show_dialog_share=document.querySelector('button.open_share');

var modal_save=document.querySelector('dialog.save');
var modal_share=document.querySelector('dialog.share');

let save=document.querySelector('dialog.save > button.save');
let close_save=document.querySelector('dialog.save > button.close');
let close_share=document.querySelector('dialog.share > button.close');


show_dialog_save.addEventListener('click', () => {
  hide_notices();
  modal_save.showModal();
});

show_dialog_share.addEventListener('click', () => {
  modal_share.showModal();
});

save.addEventListener('click', async() => {
  sheet_id = document.querySelector('#sheet').dataset.id

  let fields = document.querySelectorAll('input[type="text"]');

  // Build the sheet object to send in the request
  sheet = {};
  for (let i = 0; i < fields.length; i++) {
    // Make sure we send either null or an actual value
    sheet[fields[i].name] = fields[i].value ? fields[i].value : null;
  }

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
      if (response.errors) {
        show_notice_fail("Validation failed unfortunately", response.errors);
      } else {
        show_notice_fail();
      }
    }
  // Create sheet
  } else {
    console.log(`Creating sheet`);
    response = await create_sheet(sheet);

    if (response && response.id) {
      show_notice_success();
      setTimeout(() => {
        window.location.href = `/${response.id}`
      }, 500);
    } else {
      if (response.errors) {
        show_notice_fail("Validation failed unfortunately", response.errors);
      } else {
        show_notice_fail();
      }
    }
  }
  console.log(response);
})

close_share.addEventListener('click', async() => {
  modal_share.close();
});

close_save.addEventListener('click', async() => {
  modal_save.close();
});

function show_notice_success() {
  document.querySelector('dialog .notice.success').style.display = "block";
}

function show_notice_fail(message_override = null, errors = []) {
  if (message_override) {
    document.querySelector('dialog .notice.fail').innerHTML = message_override;
  }
  if (errors) {
    document.querySelector('dialog .notice.fail').innerHTML += "<br /><br />Errors:";
    errors.forEach((error) => {
      document.querySelector('dialog .notice.fail').innerHTML += `<br />- ${error}`
    });
  }
  document.querySelector('dialog .notice.fail').style.display = "block";
}

function hide_notices() {
  document.querySelector('dialog .notice.success').style.display = "none";
  document.querySelector('dialog .notice.fail').style.display = "none";
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
