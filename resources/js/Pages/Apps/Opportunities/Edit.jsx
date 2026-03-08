import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Edit({ opportunity }) {
  const { data, setData, put, errors } = useForm({
        opportunity_no: opportunity.opportunity_no ?? '',
        title: opportunity.title ?? '',
        lead_id: opportunity.lead_id ?? '',
        customer_id: opportunity.customer_id ?? '',
        assigned_to: opportunity.assigned_to ?? '',
        opportunity_type: opportunity.opportunity_type ?? '',
        estimated_value: opportunity.estimated_value ?? '',
        probability: opportunity.probability ?? '',
        stage: opportunity.stage ?? '',
        status: opportunity.status ?? '',
  })

  const submit = (e) => {
    e.preventDefault()
    put(route('apps.opportunities.update', opportunity.id))
  }

  return (
    <>
      <Head title='Edit Opportunity' />
      <Card title='Edit Opportunity' form={submit} footer={<Button type='submit' label='Update' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Opportunity No' type='text' value={data.opportunity_no} onChange={e => setData('opportunity_no', e.target.value)} errors={errors.opportunity_no} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Title' type='text' value={data.title} onChange={e => setData('title', e.target.value)} errors={errors.title} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Lead ID' type='text' value={data.lead_id} onChange={e => setData('lead_id', e.target.value)} errors={errors.lead_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Customer ID' type='text' value={data.customer_id} onChange={e => setData('customer_id', e.target.value)} errors={errors.customer_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Assigned To' type='text' value={data.assigned_to} onChange={e => setData('assigned_to', e.target.value)} errors={errors.assigned_to} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Type' type='text' value={data.opportunity_type} onChange={e => setData('opportunity_type', e.target.value)} errors={errors.opportunity_type} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Estimated Value' type='text' value={data.estimated_value} onChange={e => setData('estimated_value', e.target.value)} errors={errors.estimated_value} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Probability' type='text' value={data.probability} onChange={e => setData('probability', e.target.value)} errors={errors.probability} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Stage' type='text' value={data.stage} onChange={e => setData('stage', e.target.value)} errors={errors.stage} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Status' type='text' value={data.status} onChange={e => setData('status', e.target.value)} errors={errors.status} />
              </div>
        </div>
      </Card>
    </>
  )
}

Edit.layout = page => <AppLayout children={page} />
