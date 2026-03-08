import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Create() {
  const { data, setData, post, errors } = useForm({
        customer_id: '',
        name: '',
        position: '',
        email: '',
        phone: '',
        is_primary: '',
  })

  const submit = (e) => {
    e.preventDefault()
    post(route('apps.customer-contacts.store'))
  }

  return (
    <>
      <Head title='Tambah Customer Contact' />
      <Card title='Tambah Customer Contact' form={submit} footer={<Button type='submit' label='Simpan' variant='gray' />}>
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

Create.layout = page => <AppLayout children={page} />
