<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\LeadModel;
use App\Models\SpamRuleModel;

class Spam extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('spam')) { return $resp; }

        return $this->render('admin/spam/index', [
            'title'      => 'Spam Protection',
            'rules'      => (new SpamRuleModel())->orderBy('id', 'desc')->findAll(),
            'leadCount'  => (new LeadModel())->where('status', 'junk')->countAllResults(),
            'contactJunk' => \App\Models\ContactModel::class ? db_connect()->table('contacts')->where('status', 'junk')->countAllResults() : 0,
        ]);
    }

    public function addRule()
    {
        if ($resp = $this->guard('spam')) { return $resp; }
        $type  = (string) $this->request->getPost('rule_type');
        $value = trim((string) $this->request->getPost('value'));
        if (! in_array($type, ['ip', 'keyword', 'email_domain'], true) || $value === '') {
            return redirect()->back()->with('error', 'Pick a rule type and enter a value.');
        }
        (new SpamRuleModel())->insert(['rule_type' => $type, 'value' => $value, 'notes' => $this->request->getPost('notes'), 'is_active' => 1]);
        ActivityLogModel::record('create', 'spam', "{$type}: {$value}");

        return redirect()->to('/admin/spam')->with('success', 'Block rule added.');
    }

    public function deleteRule(int $id)
    {
        if ($resp = $this->guard('spam')) { return $resp; }
        (new SpamRuleModel())->delete($id);
        ActivityLogModel::record('delete', 'spam', "Rule #{$id}");

        return redirect()->to('/admin/spam')->with('success', 'Rule removed.');
    }

    public function markLeadsJunk()
    {
        if ($resp = $this->guard('spam')) { return $resp; }
        $ids = (array) $this->request->getPost('ids');
        foreach ($ids as $id) {
            if (is_numeric($id)) {
                (new LeadModel())->update((int) $id, ['status' => 'junk']);
            }
        }
        ActivityLogModel::record('mark-junk', 'spam', count($ids) . ' leads marked junk');

        return redirect()->back()->with('success', 'Marked as junk.');
    }
}
