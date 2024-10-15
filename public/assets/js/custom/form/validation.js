const formValidationConfig = {
    fields: {
        'name': {
            validators: {
                stringLength: {
                    min: 3,
                    max: 100,
                    message: 'Nama harus antara 3 dan 100 karakter'
                },
                notEmpty: {
                    message: 'Input nama tidak boleh kosong'
                }
            }
        },
        'title': {
            validators: {
                stringLength: {
                    min: 4,
                    max: 30,
                    message: 'Judul harus antara 4 dan 30 karakter'
                },
                notEmpty: {
                    message: 'Input judul tidak boleh kosong'
                }
            }
        },
        'start_date': {

            validators: {
                notEmpty: {
                    message: 'Tanggal mulai tidak boleh kosong'
                }
            }
        },
        'end_date': {

            validators: {
                notEmpty: {
                    message: 'Tanggal berakhir tidak boleh kosong'
                }
            }
        },
        'dinas': {
            validators: {
                notEmpty: {
                    message: 'Dinas tidak boleh kosong'
                }
            }
        },
        'location': {
            validators: {
                notEmpty: {
                    message: 'Dinas tidak boleh kosong'
                }
            }
        },
        'email': {
            validators: {
                emailAddress: {
                    message: 'Alamat Email tidak valid'
                },
                stringLength: {
                    min: 4,
                    max: 50,
                    message: 'Email harus antara 5 dan 50 karakter'
                },
                notEmpty: {
                    message: 'Alamat email tidak boleh kosong'
                },
            }
        },
        'password': {
            validators: {
                stringLength: {
                    min: 6,
                    max: 16,
                    message: 'Password harus antara 6 dan 16 karakter'
                },
                notEmpty: {
                    message: 'Input password tidak boleh kosong'
                }
            }
        },
        'confirm_password': {
            validators: {
                identical: {
                    compare: function() {
                        return document.getElementById('password').value;
                    },
                    message: 'Konfirmasi password tidak sama dengan password'
                },
                notEmpty: {
                    message: 'Konfirmasi password tidak boleh kosong'
                }
            }
        },
        'role': {
            validators: {
                notEmpty: {
                    message: 'Input role tidak boleh kosong'
                }
            }
        },
        'permission[]': {
            validators: {
                notEmpty: {
                    message: 'Input permission tidak boleh kosong'
                }
            }
        },
        'keywords': {
            validators: {
                stringLength: {
                    min: 2,
                    max: 500,
                    message: 'Kata kunci harus antara 2 dan 500 karakter'
                },
                notEmpty: {
                    message: 'Kata kunci tidak boleh kosong'
                }
            }
        },
        'description': {
            validators: {
                notEmpty: {
                    message: 'Deskripsi tidak boleh kosong'
                }
            }
        },
            'phone': {
            validators: {
                stringLength: {
                    min: 7,
                    max: 15,
                    message: 'Nomor Telepon harus antara 7 dan 15 karakter'
                },
            }
        },
        'nip': {
            validators: {
                notEmpty: {
                    message: 'NIP tidak boleh kosong'
                },
                stringLength: {
                    min: 18,
                    max: 18,
                    message: 'Nip harus 18 digit'
                },
            }
        },
        'gender': {
            validators: {
                notEmpty: {
                    message: 'Gender tidak boleh kosong'
                },
            }
        },
        'address': {
            validators: {
                notEmpty: {
                    message: 'Alamat tidak boleh kosong'
                },
            }
        },
    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: '.fv-row',
            eleInvalidClass: '',
            eleValidClass: ''
        })
    }
};
const editFormValidationConfig = {
    fields: {
        'name': {
            validators: {
                stringLength: {
                    min: 3,
                    max: 100,
                    message: 'Nama harus antara 3 dan 100 karakter'
                },
                notEmpty: {
                    message: 'Input nama tidak boleh kosong'
                }
            }
        },
        'title': {
            validators: {
                stringLength: {
                    min: 4,
                    max: 30,
                    message: 'Judul harus antara 4 dan 30 karakter'
                },
                notEmpty: {
                    message: 'Input judul tidak boleh kosong'
                }
            }
        },
        'email': {
            validators: {
                emailAddress: {
                    message: 'Alamat Email tidak valid'
                },
                stringLength: {
                    min: 4,
                    max: 50,
                    message: 'Email harus antara 5 dan 50 karakter'
                },
                notEmpty: {
                    message: 'Alamat email tidak boleh kosong'
                },
            }
        },
        'start_date': {

            validators: {
                notEmpty: {
                    message: 'Tanggal mulai tidak boleh kosong'
                }
            }
        },
        'end_date': {

            validators: {
                notEmpty: {
                    message: 'Tanggal berakhir tidak boleh kosong'
                }
            }
        },
        'dinas': {
            validators: {
                notEmpty: {
                    message: 'Dinas tidak boleh kosong'
                }
            }
        },
        'location': {
            validators: {
                notEmpty: {
                    message: 'Location tidak boleh kosong'
                }
            }
        },
        'pdf_file': {
            validators: {
                notEmpty: {
                    message: 'File PDF tidak boleh kosong'
                }
            }
        },
        'password': {
            validators: {
                stringLength: {
                    min: 6,
                    max: 16,
                    message: 'Password harus antara 6 dan 16 karakter'
                },
                notEmpty: {
                    message: 'Input password tidak boleh kosong'
                }
            }
        },
        'confirm_password': {
            validators: {
                identical: {
                    compare: function() {
                        return document.getElementById('password').value;
                    },
                    message: 'Konfirmasi password tidak sama dengan password'
                },
                notEmpty: {
                    message: 'Konfirmasi password tidak boleh kosong'
                }
            }
        },
        'role': {
            validators: {
                notEmpty: {
                    message: 'Input role tidak boleh kosong'
                }
            }
        },
        'permission[]': {
            validators: {
                notEmpty: {
                    message: 'Input permission tidak boleh kosong'
                }
            }
        },
        'keywords': {
            validators: {
                stringLength: {
                    min: 2,
                    max: 500,
                    message: 'Kata kunci harus antara 2 dan 500 karakter'
                },
                notEmpty: {
                    message: 'Kata kunci tidak boleh kosong'
                }
            }
        },
        'description': {
            validators: {
                notEmpty: {
                    message: 'Deskripsi tidak boleh kosong'
                }
            }
        },
        'phone': {
            validators: {
                stringLength: {
                    min: 7,
                    max: 15,
                    message: 'Nomor Telepon harus antara 7 dan 15 karakter'
                },
            }
        },
        'nip': {
            validators: {
                notEmpty: {
                    message: 'NIP tidak boleh kosong'
                },
                stringLength: {
                    min: 18,
                    max: 18,
                    message: 'Nip harus 18 digit'
                },
            }
        },
        'gender': {
            validators: {
                notEmpty: {
                    message: 'Gender tidak boleh kosong'
                },
            }
        },
        'address': {
            validators: {
                notEmpty: {
                    message: 'Alamat tidak boleh kosong'
                },
            }
        },
    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: '.fv-row',
            eleInvalidClass: '',
            eleValidClass: ''
        })
    }
};
const filterFormValidationConfig = {
    fields: {
        'name': {
            validators: {
                stringLength: {
                    min: 3,
                    max: 100,
                    message: 'Nama harus antara 3 dan 100 karakter'
                },
            }
        },
    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: '.fv-row',
            eleInvalidClass: '',
            eleValidClass: ''
        })
    }
};