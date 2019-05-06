<?php

namespace Tests\Browser\Pages;

use App\Employee;
use App\Helpers\TestHelpers;
use App\Http\Requests\StoreEmployeeOfficialDocumentRequest;
use App\OfficialDocument;
use App\OfficialDocumentType;
use Facebook\WebDriver\Exception\TimeOutException;
use Illuminate\Support\Arr;
use Laravel\Dusk\Browser;

class EmployeeOfficialDocuments extends Page
{
    protected $employee;
    protected $document;

    /**
     * EmployeeProfile constructor.
     *
     * @param Employee              $employee
     * @param OfficialDocument|null $document
     */
    public function __construct(Employee $employee, OfficialDocument $document = null)
    {
        parent::__construct();
        $this->employee = $employee;

        if ($document) {
            $this->document = $document;
        } else {
            $this->document = factory(OfficialDocument::class)->create([
                'person_id' => $this->employee->person->id,
                'file_id' => TestHelpers::getSampleFile(),
            ]);
        }
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/employee/'.$this->employee->uuid.'/official_documents';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertPathIs($this->url())
            ->assertSee($this->employee->person->preferredName()."'s Official Documents");
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Create Official Document.
     *
     * @param Browser $browser
     *
     * @throws TimeOutException
     */
    public function createOfficialDocument(Browser $browser)
    {
        // FORM FAKER FIELDS
        $official_document_type = Arr::random(OfficialDocumentType::getDropdown());

        // FORM REQUEST
        $form_request = new StoreEmployeeOfficialDocumentRequest();
        $excluded_ids = ['upload'];

        // VIEW FORM (IF MODAL)
        $browser
            ->click('@btn-modal-block-new-document')
            ->waitFor('@modal-block-new-document')

            // TEST FOR VALIDATION MESSAGES
            ->submitForm('admin-form')
            ->assertHasRequiredInputErrors($form_request, $excluded_ids)

            // FILL IN FORM
            ->selectDropdown('official_document_type_id', $official_document_type)
            ->uploadFile('upload', url('/storage/sample-file.pdf'))

            // SUBMIT FORM
            ->submitForm('admin-form')
            ->on($this)

            // SEE SUCCESS
            ->seeSuccessDialog()

            // SEE EXPECTED VALUES ON THE PAGE
            ->assertSee($official_document_type)
            ->assertSee('sample-file.pdf');
    }

    public function deleteOfficialDocument(Browser $browser)
    {
        $browser
            ->click('@btn-delete-document-'.$this->document->id)
            ->on($this)
            ->seeSuccessDialog();
    }

}
