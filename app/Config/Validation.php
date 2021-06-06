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

	public $edit_penerima_surat = [
		'nomor-induk' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'nomor induk harus diisi'
			]
		],
		'nama-penerima' => [
			'rules'  => 'required|max_length[50]|min_length[2]',
			'errors' => [
				'required'   => 'nama lengkap harus diisi.',
				'max_length' => 'nama lengkap maksimal 50 karakter.',
				'min_length' => 'nama lengkap minimal 2 karakter.'
			]
		]
	];

	public $penerima_surat = [
		'nomor-induk' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'nomor induk harus diisi'
			]
		],
		'nama-penerima' => [
			'rules'  => 'required|max_length[50]|min_length[2]',
			'errors' => [
				'required'   => 'nama lengkap harus diisi.',
				'max_length' => 'nama lengkap maksimal 50 karakter.',
				'min_length' => 'nama lengkap minimal 2 karakter.'
			]
		],
		'password' => [
			'rules'  => 'required|min_length[8]',
			'errors' => [
				'required'   => '{field} harus diisi.',
				'min_length' => '{field} minimal 8 karakter.'
			]
		],
	];


	public $login = [
		'nomor-induk' => [
			'rules'  => 'required|max_length[20]|min_length[3]',
			'errors' => [
				'required'	 => 'nomor induk tidak boleh kosong.',
				'max_length' => 'nomor induk maksimal 20 karakter',
				'min_length' => 'nomor induk minimal 3 karakter',
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
