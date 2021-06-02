<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	public $disposisi = [
		'nomor-surat' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'nomor surat tidak ditemukan.'
			]
		],
		'penerima' => [
			'rules'  => 'required|max_length[50]',
			'errors' => [
				'required' => '{field} harus diisi.'
			]
		]
	];

	public $surat_masuk = [
		'nomor-surat' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'nomor surat harus diisi'
			]
		],
		'tanggal' => [
			'rules'  => 'required|max_length[50]',
			'errors' => [
				'required' => '{field} harus diisi.'
			]
		],
		'penerima' => [
			'rules'  => 'required',
			'errors' => [
				'required' => '{field} harus diisi.'
			]
		],
		'perihal' => [
			'rules'  => 'required|max_length[100]',
			'errors' => [
				'required'	 => '{field} harus diisi.',
				'max_length' => '{field} maksimal 100 karakter'
			]
		],
		'file-surat' => [
			'rules'  => 'uploaded[file-surat]|ext_in[file-surat,pdf,docx,doc]',
			'errors' => [
				'uploaded'	=> 'file surat harus diisi.',
				'ext_in' 	=> 'format file surat harus pdf, docx, atau doc'
			]
		],		
	];

	public $form_edit_surat_masuk = [
		'nomor-surat-baru' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'nomor surat harus diisi'
			]
		],
		'tanggal' => [
			'rules'  => 'required|max_length[50]',
			'errors' => [
				'required' => '{field} harus diisi.'
			]
		],
		'penerima' => [
			'rules'  => 'required',
			'errors' => [
				'required' => '{field} harus diisi.'
			]
		],
		'perihal' => [
			'rules'  => 'required|max_length[100]',
			'errors' => [
				'required'	 => '{field} harus diisi.',
				'max_length' => '{field} maksimal 100 karakter'
			]
		],
	];

	public $registrasi = [
		'nama' => [
			'rules'  => 'required|max_length[50]|min_length[2]',
			'errors' => [
				'required'	 => 'Nama tidak boleh kosong.',
				'max_length' => 'Nama maksimal 50 karakter',
				'min_length' => 'Nama maksimal 2 karakter',
			]
		],
		'nomor_induk' => [
			'rules'  => 'required|integer|max_length[20]|min_length[11]',
			'errors' => [
				'required'	 => 'Nomor induk tidak boleh kosong.',
				'integer'	 => 'Nomor induk harus angka numeric.',
				'max_length' => 'Nomor induk maksimal 20 karakter',
				'min_length' => 'Nomor induk maksimal 11 karakter',
			]
		],
		'password' => [
			'rules'  => 'required|max_length[50]|min_length[8]',
			'errors' => [
				'required'	 => 'Password tidak boleh kosong.',
				'max_length' => 'Password maksimal 50 karakter',
				'min_length' => 'Password maksimal 8 karakter',
			]
		],
		'konfirmasi_password' => [
			'rules'  => 'required',
			'errors' => [
				'required'	 => 'konfirmasi password tidak boleh kosong.'
			]
		]
	];

	public $login = [
		'username' => [
			'rules'  => 'required|max_length[20]|min_length[11]',
			'errors' => [
				'required'	 => '{field} tidak boleh kosong.',
				'max_length' => '{field} maksimal 20 karakter',
				'min_length' => '{field} minimal 11 karakter',
			]
		],
		'password' => [
			'rules'  => 'required|max_length[50]|min_length[8]',
			'errors' => [
				'required'	 => 'Password tidak boleh kosong.',
				'max_length' => 'Password maksimal 50 karakter',
				'min_length' => 'Password maksimal 8 karakter',
			]
		]
	];

	public $validasi_gambar = [
		'gambar' => [
			'rules'  => 'is_image[gambar]|max_size[gambar,2048]',
			'errors' => [
				'is_image'  => 'File yang diupload bukan gambar.',
				'max_size'  => '{field} maksimal 2048 Kb.',
			]
		]
	];

	public $validasi_tamu = [
		'nama_tamu' => [
			'rules'  => 'required|max_length[100]',
			'errors' => [
				'required' => 'nama tamu tidak boleh kosong.',
				'max_length' => 'nama tamu maksimal 100 karakter'
			]
		]
	];
	//--------------------------------------------------------------------
}
