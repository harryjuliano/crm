import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Create() {
  const { data, setData, post, errors } = useForm({
        lead_no: '',
        name: '',
        lead_type: 'company',
        email: '',
        phone: '',
        lead_source_id: '',
        assigned_to: '',
        status: 'new',
  })

  const submit = (e) => {
    e.preventDefault()
    post(route('apps.leads.store'))
  }

  return (
    <>
      <Head title='Tambah Lead' />
      <Card title='Tambah Lead' form={submit} footer={<Button type='submit' label='Simpan' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Lead No' type='text' value={data.lead_no} onChange={e => setData('lead_no', e.target.value)} errors={errors.lead_no} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Nama' type='text' value={data.name} onChange={e => setData('name', e.target.value)} errors={errors.name} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Tipe' type='text' value={data.lead_type} onChange={e => setData('lead_type', e.target.value)} errors={errors.lead_type} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Email' type='text' value={data.email} onChange={e => setData('email', e.target.value)} errors={errors.email} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Phone' type='text' value={data.phone} onChange={e => setData('phone', e.target.value)} errors={errors.phone} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Lead Source ID' type='text' value={data.lead_source_id} onChange={e => setData('lead_source_id', e.target.value)} errors={errors.lead_source_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Assigned To' type='text' value={data.assigned_to} onChange={e => setData('assigned_to', e.target.value)} errors={errors.assigned_to} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Status' type='text' value={data.status} onChange={e => setData('status', e.target.value)} errors={errors.status} />
              </div>
        </div>
      </Card>
    </>
  )
}

Create.layout = page => <AppLayout children={page} />
