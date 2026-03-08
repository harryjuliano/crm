import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Edit({ customerContact }) {
  const { data, setData, put, errors } = useForm({
        customer_id: customerContact.customer_id ?? '',
        name: customerContact.name ?? '',
        position: customerContact.position ?? '',
        email: customerContact.email ?? '',
        phone: customerContact.phone ?? '',
        is_primary: customerContact.is_primary ?? '',
  })

  const submit = (e) => {
    e.preventDefault()
    put(route('apps.customer-contacts.update', customerContact.id))
  }

  return (
    <>
      <Head title='Edit Customer Contact' />
      <Card title='Edit Customer Contact' form={submit} footer={<Button type='submit' label='Update' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Customer ID' type='text' value={data.customer_id} onChange={e => setData('customer_id', e.target.value)} errors={errors.customer_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Nama' type='text' value={data.name} onChange={e => setData('name', e.target.value)} errors={errors.name} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Jabatan' type='text' value={data.position} onChange={e => setData('position', e.target.value)} errors={errors.position} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Email' type='text' value={data.email} onChange={e => setData('email', e.target.value)} errors={errors.email} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Phone' type='text' value={data.phone} onChange={e => setData('phone', e.target.value)} errors={errors.phone} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Primary (0/1)' type='text' value={data.is_primary} onChange={e => setData('is_primary', e.target.value)} errors={errors.is_primary} />
              </div>
        </div>
      </Card>
    </>
  )
}

Edit.layout = page => <AppLayout children={page} />
